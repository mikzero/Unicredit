<?php

namespace Railken\Unicredit\IGFS_CG_API\init;

use SimpleXMLElement;
use Railken\Unicredit\IGFS_CG_API\IgfsUtils;

class SelectorTerminalInfo
{
    public $tid;
    public $description;
    public $payInstr;
    public $payInstrDescription;
    public $imgURL;

    public function __construct()
    {
    }

    public static function fromXml($xml)
    {
        if ($xml=="" || $xml==null) {
            return;
        }

        $dom = new SimpleXMLElement($xml, LIBXML_NOERROR, false);
        if (count($dom)==0) {
            return;
        }

        $response = IgfsUtils::parseResponseFields($dom);
        $terminal = null;
        if (isset($response) && count($response)>0) {
            $terminal = new SelectorTerminalInfo();
            $terminal->tid = (IgfsUtils::getValue($response, "tid"));
            $terminal->description = (IgfsUtils::getValue($response, "description"));
            $terminal->payInstr = (IgfsUtils::getValue($response, "payInstr"));
            $terminal->payInstrDescription = (IgfsUtils::getValue($response, "payInstrDescription"));

            if (isset($response["imgURL"])) {
                $imgURL = array();
                foreach ($dom->children() as $item) {
                    if ($item->getName() == "imgURL") {
                        $imgURL[] = $item->__toString();
                    }
                }
                $terminal->imgURL = $imgURL;
            }
        }
        return $terminal;
    }
}
