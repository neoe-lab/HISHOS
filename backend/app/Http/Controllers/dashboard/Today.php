<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\TabCompletion\Matcher\FunctionsMatcher;

class Today extends Controller
{
    public function index()
    {
        //################  connection database hosxp #################
        $hosxp_db = DB::connection('hosxp');
        // ########################################################

        $pt_opd = $this->pt_opd($hosxp_db);
        $pt_phy = $this->pt_phy($hosxp_db);
        $pt_dent =$this->pt_dent($hosxp_db);
        $pt_ipd =$this->pt_ipd($hosxp_db);
        $pt_ttm =$this->pt_ttm($hosxp_db);
        $pt_er =$this->pt_er($hosxp_db);
        $pt_or =$this->pt_or($hosxp_db);
        $pt_xray =$this->pt_xray($hosxp_db);

        return compact("pt_opd","pt_phy",'pt_dent','pt_ipd','pt_ttm','pt_er','pt_or','pt_xray');
    }





    public function pt_opd($db)
    {
        $result = $db->select("SELECT COUNT(DISTINCT hn) AS ptm_opd_hn,COUNT(DISTINCT vn) AS ptm_opd_vn
        ,COUNT(DISTINCT IF(vstdate = DATE_FORMAT(NOW(),'%Y-%m-%d'),vn,NULL)) AS pt_opd_today
        FROM ovst
        WHERE vstdate BETWEEN DATE_FORMAT(NOW(),'%Y-%m-01') AND DATE_FORMAT(NOW(),'%Y-%m-%d') ");

        return $result;
    }
    public function pt_phy($db)
    {
        $result = $db->select("SELECT COUNT(DISTINCT hn) AS ptm_phy_hn,COUNT(DISTINCT vn) AS ptm_phy_vn
        ,COUNT(DISTINCT IF(vstdate = DATE_FORMAT(NOW(),'%Y-%m-%d'),vn,NULL)) AS pt_phy_today
        FROM physic_main
        WHERE vstdate BETWEEN DATE_FORMAT(NOW(),'%Y-%m-01') AND DATE_FORMAT(NOW(),'%Y-%m-%d')
        ");
        return $result;
    }
    public function pt_ipd($db)
    {
        $result = $db->select("SELECT COUNT(DISTINCT hn) AS ptm_ipd_hn,COUNT(DISTINCT an) AS ptm_ipd_an
        ,COUNT(DISTINCT IF(regdate = DATE_FORMAT(NOW(),'%Y-%m-%d'),an,NULL)) AS pt_ipd_today
        FROM ipt
        WHERE regdate BETWEEN DATE_FORMAT(NOW(),'%Y-%m-01') AND DATE_FORMAT(NOW(),'%Y-%m-%d')");

        return $result;
    }
    public function pt_dent($db)
    {
        $result = $db->select("SELECT COUNT(DISTINCT hn) AS ptm_dent_hn,COUNT(DISTINCT vn) AS ptm_dent_vn
        ,COUNT(DISTINCT IF(vstdate = DATE_FORMAT(NOW(),'%Y-%m-%d'),vn,NULL)) AS pt_dent_today
        FROM dtmain
        WHERE vstdate BETWEEN DATE_FORMAT(NOW(),'%Y-%m-01') AND DATE_FORMAT(NOW(),'%Y-%m-%d')");
        return $result;
    }
    public function pt_ttm($db)
    {
        $result = $db->select("SELECT COUNT(DISTINCT hn) AS ptm_ttm_hn,COUNT(*) AS ptm_ttm_vn
        ,COUNT(DISTINCT IF(service_date = DATE_FORMAT(NOW(),'%Y-%m-%d'),vn,NULL)) AS pt_ttm_today
        FROM health_med_service
        WHERE service_date BETWEEN DATE_FORMAT(NOW(),'%Y-%m-01') AND DATE_FORMAT(NOW(),'%Y-%m-%d')");
            #AND in_hospcode_service = 'Y' ";
        return $result;
    }

    public function pt_er($db)
    {
        $result = $db->select("SELECT COUNT(DISTINCT o.hn) AS ptm_er_hn,COUNT(DISTINCT o.vn) AS ptm_er_vn
        ,COUNT(DISTINCT IF(er.vstdate = DATE_FORMAT(NOW(),'%Y-%m-%d'),o.vn,NULL)) AS pt_er_today
            FROM er_regist er
            LEFT OUTER JOIN ovst o ON o.vn = er.vn
            LEFT OUTER JOIN er_pt_type et ON et.er_pt_type = er.er_pt_type
            WHERE er.vstdate BETWEEN DATE_FORMAT(NOW(),'%Y-%m-01') AND DATE_FORMAT(NOW(),'%Y-%m-%d')
            AND er.er_pt_type IN (SELECT er_pt_type FROM er_pt_type WHERE accident_code = 'Y')");
        return $result;
    }
    public function pt_or($db)
    {
        $result = $db->select("SELECT COUNT(DISTINCT hn) AS ptm_or_hn
        ,COUNT(hn) AS ptm_or_vn
        ,COUNT(IF(patient_department = 'OPD',vn,NULL)) AS ptm_or_opd
        ,COUNT(IF(patient_department = 'IPD',an,NULL)) AS ptm_or_ipd
        ,COUNT(IF(operation_date = DATE_FORMAT(NOW(),'%Y-%m-%d'),hn,NULL)) AS pt_or_today
        FROM operation_list
        WHERE operation_date BETWEEN DATE_FORMAT(NOW(),'%Y-%m-01') AND DATE_FORMAT(NOW(),'%Y-%m-%d')");
        return $result;
    }
    public function pt_xray($db)
    {
        $result = $db->select("SELECT COUNT(DISTINCT hn) AS ptm_xray_hn,COUNT(vn) AS ptm_xray_vn
        ,COUNT(IF(examined_date = DATE_FORMAT(NOW(),'%Y-%m-%d'),vn,NULL)) AS pt_xray_today
        FROM xray_report
        WHERE examined_date BETWEEN DATE_FORMAT(NOW(),'%Y-%m-01') AND DATE_FORMAT(NOW(),'%Y-%m-%d')");
        return $result;
    }
}
