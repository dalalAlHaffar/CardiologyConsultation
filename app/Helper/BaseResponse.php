<?php

namespace App\Helper;

use App\Models\Common\Setting;
use App\Models\ECommerce\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class BaseResponse
{
    protected $_data = [];
    protected $_meta = [];
    protected $_status = 200;
    protected $_send_status = 200;
    protected $_message = "";
    protected $_success = true;
    protected $_pagination = [];
    protected $_with_grouping = false;
    protected $_currency = "";
    protected $_can_encrypt = false;
    protected $_bkhidemtak_is_active = false;
    protected $connection = "mysql";
    protected $_from_website;
    private $logger, $response;

    public function __construct()
    {
        $this->logger = new Logger('BaseResponse');
        $this->_from_website = false;
        $arr_uri =  explode('/', 'web');
        $condCount = 0;

        foreach ($arr_uri  as $item) {
            if ($item === "web") {
                $condCount++;
            } else if ($item === "api") {
                $condCount++;
            }
        }

        if ($condCount > 1) {
            $this->_from_website = true;
        }

        $this->logger->pushHandler(new RotatingFileHandler(
            storage_path("logs/daily_log_controller.log"),
            10,
            Logger::DEBUG,
            true,
            0777
        ));
        $this->logger->pushHandler(new FirePHPHandler());
    }


    private function initValues()
    {
        $this->_data = [];
        $this->_meta = [];
        $this->_status = 200;
        $this->_send_status = 200;
        $this->_message = "";
        $this->_success = true;
        $this->_with_grouping = false;
  }

    public function fromWebsite()
    {
        $this->_from_website = true;
    }

    public function addToData($object)
    {
        $this->_data = array_merge($this->_data, $object);
    }

    public function addToPagination($object)
    {
        $this->_pagination = array_merge($this->_pagination, $object);
    }

    public function addToMeta($object)
    {
        $this->_meta = array_merge($this->_meta, $object);
    }

    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    public function setData($data)
    {
        $this->_data = $data;
    }
    public function setMeta($meta)
    {
        $this->_meta = $meta;
    }

    public function setStatus($status)
    {
        $this->_status = $status;
    }

    public function setSendStatus($status)
    {
        $this->_send_status = $status;
    }

    public function setObject($object)
    {
        $this->_object = $object;
    }

    public function setMessage($message)
    {
        $this->_message = $message;
    }

    public function successful($answer)
    {
        $this->_success = $answer;
    }

    public function getData()
    {
        return $this->_data;
    }

    public function getMeta()
    {
        return $this->_meta;
    }

    public function paginate(Request $request, $query,  $columns = ['*'], $delayedOders = [])
    {
        if ($this->_with_grouping == false) {
            $tmpQuery = $query->toSql();
            $tmpQuery = substr($tmpQuery, strpos($tmpQuery, "from") + 4);
            $count = DB::connection($this->connection)->table(DB::raw("{$tmpQuery}"))
                ->mergeBindings($query->getQuery()) // you need to get underlying Query Builder
                ->count();
        } else {
            $count = DB::connection($this->connection)->table(DB::raw("({$query->toSql()}) as num_rows"))
                ->mergeBindings($query->getQuery()) // you need to get underlying Query Builder
                ->count();
        }

        if ($request->offset > $count) {
            $request->merge(['page' => 1]);
            $request->merge(['offset' => 0]);
        }

        if (count($delayedOders) > 0) {
            foreach ($delayedOders as $order) {
                $query =   $query->orderBy($order['column'], $order['dir']);
            }
        }

        $this->_data       = $query->skip($request->offset)->take($request->limit)->get($columns);
        $this->_pagination = [
            "page"           => $request->page,
            "total"          => $count,
            "total_pages"    => ceil($count / $request->limit),
            "per_page"       => $request->limit
        ];

        return $this;
    }


    public function withGrouping()
    {
        $this->_with_grouping = true;
        return $this;
    }

    public function withEncrypting()
    {
        $this->_can_encrypt = true;
        return $this;
    }

    public function send($input = [], $isPaginated = false)
    {

        $this->initValues();

        foreach ($input as $key => $value) {
            if ($key == "data") {
                $this->setData($value);
            } elseif ($key == "meta") {
                $this->setMeta($value);
            } elseif ($key == "status") {
                if ($value != 200) {
                    $this->_success       = false;
                }
                $this->_status = $value;
                $this->_send_status = $value;
            } elseif ($key == "send_status") {
                $this->_send_status = $value;
            } elseif ($key == "pagination") {
                $this->_pagination = [
                    "page"           => $value['page'],
                    "total"          => $value['count'],
                    "total_pages"    => ceil($value['count'] / $value['limit']),
                    "per_page"       => $value['limit']
                ];
            } elseif ($key == "message") {
                // TODO do localization here ...
                $this->_message = $value;
            }
        }

        return $this->transform($isPaginated);
    }

    private function transform($isPaginated)
    {

        $rtnObj = [];
        if ($isPaginated == true) {

            $rtnObj['data'] = [
                'items'        => $this->_data,
                "page"         => (int) $this->_pagination["page"],
                "total"        => (int) $this->_pagination["total"],
                "total_pages"  => (int) $this->_pagination["total_pages"],
                "per_page"     => (int) $this->_pagination["per_page"],
            ];
        } else {
            $rtnObj['data'] = $this->_data;
        }
        $is_encrepted = $this->_can_encrypt == true || $this->_from_website == true;
        if(request()->header('isTest') == true){
            $is_encrepted = false;
        }
        $rtnObj["meta"]  =  array_merge($this->_meta, [
            "status"                =>  $this->_success,
            "message"               =>  $this->_message,
            "statusNumber"          =>  $this->_send_status,
    
        ]);

        // if ($this->_can_encrypt == true || $this->_from_website == true) {
        //     $rtnObj = $this->encrypting($rtnObj);
        // }

        return response()->json($rtnObj, $this->_status);
    }

    public function encrypting($rtnObj)
    {
        return Crypt::encryptString(json_encode($rtnObj));
    }
}
