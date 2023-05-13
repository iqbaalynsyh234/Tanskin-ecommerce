<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('check_login'))
{
    function check_login()
    {
        $ci =& get_instance();
        if ($ci->session->userdata('admin_login') === FALSE || !($ci->session->userdata('admin_login')))
        {
            redirect(base_url() . 'entersite/login');
        }
    }
}

if ( ! function_exists('input_clean'))
{
    function input_clean($post){
        $ci =& get_instance();
        return htmlspecialchars($ci->security->xss_clean($post));
    }
}

if ( ! function_exists('pre'))
{
    function pre($data, $next = 0){
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        if(!$next){ exit; }
    }
}

if ( ! function_exists('publish')) {
    function publish($enum){
        if($enum == '11'){ $publish = 'Yes'; }else{ $publish = 'No'; }
        return $publish;
    }
}

if ( ! function_exists( 'ol' )) {
    function ol($list){
        if($list != null){
            $ol = ' - '.$list;
        }else{
            $ol = $list;
        }
        return $ol;
    }
}

if ( ! function_exists( 'cetak' ) ) {
    function cetak($string){
        echo htmlentities($string, ENT_QUOTES, 'UTF-8');
    }
}

if ( ! function_exists( 'getid' ) ) {
    function getid($segment){
        $kata = explode(".html", $segment);
        $link = substr($kata[0], strrpos($kata[0], '-') + 1);
        return $link;
    }
}

if ( ! function_exists( 'encyript_password' ) ) {
    function encyript_password( $password ) {
        $salt = '!@#$%^&*()<>?:9876543210ABCDEFG';
        return md5( $password.md5( $password.$salt ) );
    }
}

if ( ! function_exists( 'rupiah' ) ) {
    function rupiah($nilai){
       if($nilai==''){
          $nilai = 0;
       }
       $rupiah = number_format($nilai, 0, ',', '.');
       return $rupiah;
    }
}

if ( ! function_exists( 'rupiah_to_number' ) ) {
    function rupiah_to_number($rupiah){
       return intval(preg_replace("/[^0-9]/", "", $rupiah));
    }
}

if ( ! function_exists( 'hitungHari' ) ) {
    function hitungHari($awal,$akhir){
        $CheckInX  = explode("-", $awal);
        $CheckOutX = explode("-", $akhir);
        $date1     = mktime(0, 0, 0, $CheckInX[1],$CheckInX[2],$CheckInX[0]);
        $date2     = mktime(0, 0, 0, $CheckOutX[1],$CheckOutX[2],$CheckOutX[0]);
        $interval  =($date2 - $date1)/(3600*24);

        if($interval>=0){
            return  $interval;
        }else{
            return  $interval;
        }
    }
}

if ( ! function_exists( 'my_slug' ) ) {
    function my_slug( $string ) {
        $string_lowercase = strtolower( $string );
        $filter = str_replace( array( ' ', '.', ',', ':', '/', '*', '^', '%', '$', '#', '(', ')', '_', "'", '"', '&', '~', '+', ';', '[', ']', '|', '{', '}', '`', '@', '`', '!'), '-', $string_lowercase );
        $max_dash    = 1;
        $val_find    = '-';
        $val_replace = '';

        while ( $max_dash > 0 ) {
            $val_find = $val_find . '-';
            $val_replace = $val_replace . '-';
            $max_dash--;
        }

        while ( strrpos( $filter, $val_find ) !== false ) {
             $filter = str_replace( $val_find, $val_replace, $filter );
        }
        return $filter;
    }
}

if ( ! function_exists( 'numbertostring' ) ) {
    function numbertostring($x) {
        $x = abs($x);
        $angka = array(" ", "satu", "dua", "tiga", "empat", "lima",
        "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = " ";
        if ($x <12) {
        $temp = " ".$angka[$x];
        } else if ($x <20) {
        $temp = kekata($x - 10). " belas";
        } else if ($x <100) {
        $temp = kekata($x/10)." puluh". kekata($x % 10);
        } else if ($x <200) {
        $temp = " seratus" . kekata($x - 100);
        } else if ($x <1000) {
        $temp = kekata($x/100) . " ratus" . kekata($x % 100);
        } else if ($x <2000) {
        $temp = " seribu" . kekata($x - 1000);
        } else if ($x <1000000) {
        $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
        } else if ($x <1000000000) {
        $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
        } else if ($x <1000000000000) {
        $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
        } else if ($x <1000000000000000) {
        $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
        }
        return $temp;
    }
}

if ( ! function_exists( 'kilo' ) ) {
    function kilo($angka, $batas = 0.3){
    $b = floor($angka);
    $c = $angka - $b;
    if($angka < 1){
        $d = ceil($angka);
    }
    else{
        if($c < $batas)
        {
            $d = floor($angka);
        }
        else
        {
            $d = ceil($angka);
        }
    }
    return $d;
    }
}

if ( ! function_exists( 'rp' ) ) {
    function rp( $number ) {
        $money = number_format( $number,0,',','.' );
    return $money;
    }
}


/**
* ----------------------------------------
* BASE 64 ENCODE
* ----------------------------------------
*/
if ( ! function_exists( 'encode64' ) ) {
function encode64($data) { 
  return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
} 
}
/**
* ----------------------------------------
* BASE 64 DECODE
* ----------------------------------------
*/
if ( ! function_exists( 'decode64' ) ) {
function decode64($data) { 
  return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
}
}

if ( ! function_exists( 'static_menu' ) ) {
    function static_menu($where = array()) { 
        $ci   =& get_instance();

        $target = array('p.publish' => '11');

        if(!empty($where)){
            if(!empty($where)){
                foreach ($where as $key => $value) {
                    $target[$key] = $value;
                }
            }
        }

        $ci->db->join('kategori_tambahan kt', 'kt.id=p.kategori');
        $ci->db->order_by('p.section', 'asc');
        $data =  $ci->db->get_where('static_page p', $target);

        return $data->result_array();
    }
}

if ( ! function_exists( 'get_data' ) ) {
    function get_data($table, $where = array(), $returns = FALSE) { 
        $ci   =& get_instance();

        $target = array();

        if(!empty($where)){
            if(!empty($where)){
                foreach ($where as $key => $value) {
                    $target[$key] = $value;
                }
            }
        }

        $data =  $ci->db->get_where($table, $target);
        if($returns){
            return $data->result_array();
        }else{
            return $data->row_array();
        }
    }
}

if ( ! function_exists( 'igfeed' ) ) {
    function igfeed($token) { 
        $curl = curl_init();
        $url  = 'https://graph.instagram.com/me/media?fields=media_url,media_type,permalink&access_token='.$token;
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'Codular Sample cURL Request'
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($resp, true);
        return (!empty($data['data'])) ? $data : array();
    }
}

if ( ! function_exists('create_seo_url'))
{
    function create_seo_url($url, $id="")
    {
        $ci =& get_instance();
        $url = url_title(trim($url), 'dash', TRUE);
        if(!empty($id)){
            $ci->db->where("ID_item !=" , $id);
        }
        $check = $ci->db->select('url')->get_where('products', array('url' => $url));
        if($check->row_array()){
            return create_seo_url($url.'-1');
        } else {
            return $url;
        }
    }
}

if ( ! function_exists('category_nav_menu')){
    function category_nav_menu(){

        $ci =& get_instance();

        $table = "category";
        $query = $ci->db->order_by('p.ID_cat','asc')
                ->get_where($table ." p",array('p.publish' => '11'));

        $cat = array(
            'items'   => array(),
            'parents' => array()
        );

        foreach ($query->result() as $cats) {
            $cat['items'][$cats->ID_cat] = $cats;
            $cat['parents'][$cats->parent_id][] = $cats->ID_cat;
        }

        if ($cat) {
            $result = build_category_menu(0, $cat);
            return $result;
        } else {
            return FALSE;
        }

    }
}

if ( ! function_exists('build_category_menu')){
    function build_category_menu($parent, $menu){
        $html  = "";
        $class = ($parent == 0) ? 'parent' : '';
        if (isset($menu['parents'][$parent])) {
            $html .= "<ul>";
            foreach ($menu['parents'][$parent] as $itemId) {
                if (!isset($menu['parents'][$itemId])) {
                    $html .= "<li class='".$class."'><a class='lhover' href='" .base_url('shop/catalogue/'). $menu['items'][$itemId]->link . "'><span>" . $menu['items'][$itemId]->kategori . "</span></a></li>";
                }
                if (isset($menu['parents'][$itemId])) {
                    $html .= "<li class='has-child ".$class."'><a class='lhover' href='" .base_url('shop/catalogue/'). $menu['items'][$itemId]->link . "'><span>" . $menu['items'][$itemId]->kategori . "</span></a>";
                    $html .= build_category_menu($itemId, $menu);
                    $html .= "</li>";
                }
            }
            $html .= "</ul>";
        }
        return $html;

    }
}

if ( ! function_exists('get_user_agent'))
{
    function get_user_agent()
    {      
        $ci =& get_instance();
            $ci->load->library('user_agent');

        if ($ci->agent->is_browser())
        {
            $agent = $ci->agent->browser().' '.$ci->agent->version();
        }
        elseif ($ci->agent->is_robot())
        {
            $agent = $ci->agent->robot();
        }
        elseif ($ci->agent->is_mobile())
        {
            $agent = $ci->agent->mobile();
        }
        else
        {
            $agent = 'Unidentified User Agent';
        }
        return $ci->agent->platform(). ' - ' .$agent;
    }
}

if ( ! function_exists('file_upload'))
{
    function file_upload($field_name, $folder, $debug = FALSE)
    {
        $ci =& get_instance();
        
        
        $config = array(
                    'upload_path'   => $folder,
                    'allowed_types' => 'gif|jpeg|jpg|png'
                );
                
        $ci->load->library('upload');
        $ci->upload->initialize($config);
        
        // If upload failed, whether it's permission problem OR no chosen files,
        if ( ! $ci->upload->do_upload($field_name))
        {
            // Return errors if debug is true.
            return ($debug == TRUE) ? $ci->upload->display_errors() : '';
        }
        else return $ci->upload->data();
    }
}

if ( ! function_exists('image_resize'))
{
    function image_resize($image, $width, $height, $keep_ratio = TRUE)
    {
        if ($image)
        {
            // Does the current resolution exceed limit?
            if ($image['image_width'] > $width || $image['image_height'] > $height)
            {
                $config = array(
                            'height'        => $height,
                            'width'         => $width,
                            'source_image'  => $image['full_path'],
                            'new_image'     => $image['file_path'],
                            'maintain_ratio'=> $keep_ratio
                        );
                        
                $ci =& get_instance();
                $ci->load->library('image_lib');
                
                $ci->image_lib->initialize($config);
                 if (!$ci->image_lib->resize()) {
                    echo $ci->image_lib->display_errors();
                }           }
            return $image;
        }
    }
}

if ( ! function_exists('select_all_row'))
{
    function select_all_row($table, $where="", $single=FALSE , $sort="", $sort_field="")
    {
        $ci =& get_instance();
        if(!empty($where))
        {
            $ci->db->where($where);
        }

        if($single){
            if(!empty($sort)){
                if(!empty($sort_field)){
                    return $ci->db->order_by($sort_field,$sort)->get($table)->row_array();
                } else {
                    return $ci->db->order_by('sort',$sort)->get($table)->row_array();
                }
            } else {
                return $ci->db->get($table)->row_array();
            }
        }
        else {
            if(!empty($sort)){
                
                if(!empty($sort_field)){
                    return $ci->db->order_by($sort_field,$sort)->get($table)->result_array();
                } else {
                    return $ci->db->order_by('sort',$sort)->get($table)->result_array();
                }
            } else {
                return $ci->db->get($table)->result_array();
            }
        }

    }
}

if ( ! function_exists( 'total_weight_cart' ) ) {
    function total_weight_cart(){
        $ci =& get_instance();
        $weight = 0;
        foreach ($ci->cart->contents() as $items) {
            $weight = $weight + ($items['weight'] * $items['qty']);
        }
        $weight = kilo($weight / 1000);
        return $weight;
    }
}

if ( ! function_exists( 'setting_value' ) ) {
    function setting_value($key){
        $ci =& get_instance();
        $return = $ci->db->get_where('setting', array('key' => $key))->row_array();
        return $return['value'];
    }
}

if ( ! function_exists( 'barcode_gen' ) ) {
    function barcode_gen($code){
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        $barcode = base64_encode($generator->getBarcode($code, $generator::TYPE_CODE_128));
        return $barcode;
    }
}

if ( ! function_exists( 'week_ago' ) ) {
    function week_ago(){
        $today    = date('d-m-Y');
        $week_ago = date('d-m-Y', strtotime($today . "-7 days"));
        return $week_ago;
    }
}


if ( ! function_exists('file_import'))
{
    function file_import($field_name, $folder, $name , $debug = FALSE)
    {
        $ci =& get_instance();
        
        $config = array(
                    'upload_path'   => $folder,
                    'allowed_types' => 'xlsx|xls|csv|gif|jpeg|jpg|png',
                    'file_name'     => $name
                );
                
        $ci->load->library('upload');
        $ci->upload->initialize($config);
        $ci->upload->overwrite = true;
        
        if ( ! $ci->upload->do_upload($field_name))
        {
            return ($debug == TRUE) ? $ci->upload->display_errors() : '';
        }
        else return $ci->upload->data();
    }
}

if ( ! function_exists( 'limitChar' ) ) {
    function limitChar( $content, $limit ) {
        if ( strlen( $content ) <= $limit ) {
            return $content;
        } else {
            $excerpt = substr( $content, 0, $limit );
            return $excerpt.'...';
        }
    }
}


if ( ! function_exists( 'group_by' ) ) {
    function group_by($key, $data) {
        $result = array();

        foreach($data as $val) {
            if(array_key_exists($key, $val)){
                $result[$val[$key]][] = $val;
            }else{
                $result[""][] = $val;
            }
        }

        return $result;
    }
}

if ( ! function_exists('link_WA')){
    function link_WA($number, $text="", $hello=""){
        // bisa dikombinasiin dengan function sayHello()

        $number = preg_replace("/[^0-9]/", '', $number);
        if(substr(trim($number), 0, 3)=='+62'){
            $number = '62'.substr(trim($number), 1);
        }
        elseif(substr(trim($number), 0, 1)=='0'){
            $number = '62'.substr(trim($number), 1);
        }

        if($text) {
           $text = rawurlencode($text);
        }
        $link = 'https://wa.me/'.$number.'?text='.$hello . $text;
        return $link;
    }
}

if ( ! function_exists('badge')){
    function badge($table, $where){
        $ci =& get_instance();
        $badge = $ci->db->get_where($table, $where)->num_rows();
        return ($badge > 0) ? $badge : '';
    }
}

if ( ! function_exists('sendemail')){
    function sendemail($data = array(), $clear = ''){
       
        $ci =& get_instance();
        $ci->load->library('email');
        
        $config['protocol']       = 'smtp';
        $config['smtp_host']      = 'ssl://smtp.gmail.com';
        $config['smtp_port']      = 465;
        $config['smtp_user']      = setting_value('mail_username');
        $config['smtp_pass']      = setting_value('mail_password');
        $config['smtp_timeout']   = 20;
        
       
        $config['wordwrap']       = TRUE;
        $config['wrapchars']      = 76;
        $config['mailtype']       = 'html';
        $config['charset']        = 'utf-8';
        $config['validate']       = FALSE;
        $config['priority']       = 3;
        $config['crlf']           = "\r\n";
        $config['newline']        = "\r\n";
        $config['bcc_batch_mode'] = FALSE;
        $config['bcc_batch_size'] = 200;
        $config['validation']     = TRUE;  
        
        $ci->email->initialize($config);
        $ci->email->set_newline("\r\n");

        $default_email   = setting_value('email');
        $default_company = setting_value('site_name');

        if(!empty($data['name']) && !empty($data['from']))
        {
            $ci->email->from($data['from'], $data['name']); //email perusahaan , nama perusahaan
        }else
        {
            $data['from'] = $default_email;
            $data['name'] = $default_company;
            $ci->email->from($default_email, $default_company);
        }        

        if(!empty($data['reply_to_name']) && !empty($data['reply_to']))
        {
            $ci->email->reply_to($data['reply_to'], $data['reply_to_name']); //email penerima , nama penerima
        }
        if(!empty($data['reply_cms']) )
        {
            $template['reply_cms'] = $data['reply_cms'];
        }

        $ci->email->to($data['to']);
        if(!empty($data['cc'])){ $ci->email->cc($data['cc']); }
        if(!empty($data['bcc'])){ $ci->email->bcc($data['bcc']); }

        $ci->email->subject($data['subject']);

        $template['title']      = $data['title'];
        $template['message']    = $data['message'];
        $template['to']         = $data['to'];
        $template['to_name']    = $data['to_name'];
        $template['from']       = $data['from'];
        $template['name']       = $data['name'];
        $template['link']       = !empty($data['link'])?$data['link']:'';
        $template['link_title'] = !empty($data['link_title'])?$data['link_title']:'';
        $template['email_view'] = !empty($data['email_view'])?$data['email_view']:'template_send_email';
     
        $email_view = $ci->load->view('template/' .$template['email_view'], $template, TRUE);
        
        $ci->email->message($email_view);
        $ci->email->send();
        // echo $ci->email->print_debugger();
        
    }

    function readable_random_string($length = 6)
    {  
        $string = '';
        $vowels = array("a","e","i","o","u");  
        $consonants = array(
            'b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 
            'n', 'p', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z'
        );  

        $max = $length / 2;
        for ($i = 1; $i <= $max; $i++)
        {
            $string .= $consonants[rand(0,19)];
            $string .= $vowels[rand(0,4)];
        }

        return $string;
    }

    function create_image($voucher_name, $voucherdate, $template){
        $img          = imagecreatefromjpeg(FCPATH.'assets/image/voucher/'.$template);
        
        $white        = imagecolorallocate($img, 0, 0, 0);
        $txt          = $voucher_name;
        $font         = FCPATH.'assets/webfonts/fonts/OpenSans-Bold.ttf'; 
        
        $width        = imagesx($img);
        $height       = imagesy($img);
        
        $text_size    = imagettfbbox(36, 0, $font, $txt);
        $text_width   = max([$text_size[2], $text_size[4]]) - min([$text_size[0], $text_size[6]]);
        $text_height  = max([$text_size[5], $text_size[7]]) - min([$text_size[1], $text_size[3]]);
        
        $centerX      = ceil(($width - $text_width) / 2) - 335;
        $centerX      = $centerX<0 ? 0 : $centerX;
        $centerY      = ceil(($height - $text_height) / 2) - 75;
        $centerY      = $centerY<0 ? 0 : $centerY;
        imagettftext($img, 36, 0, $centerX, $centerY, $white, $font, strtoupper($txt));
        
        
        imagejpeg($img, 'assets/image/voucher/voucher_'.$voucher_name.'.jpg');
        $img          = imagecreatefromjpeg(FCPATH.'assets/image/voucher/voucher_'.$voucher_name.'.jpg');
        
        $white        = imagecolorallocate($img, 0, 0, 0);
        $days         = $voucherdate;
        $txt          = date('d M Y', strtotime($days . ' +14 day'));;
        
        $width        = imagesx($img);
        $height       = imagesy($img);
        
        $text_size    = imagettfbbox(18, 0, $font, $txt);
        $text_width   = max([$text_size[2], $text_size[4]]) - min([$text_size[0], $text_size[6]]);
        $text_height  = max([$text_size[5], $text_size[7]]) - min([$text_size[1], $text_size[3]]);
        
        $centerX      = ceil(($width - $text_width) / 2) - 370;
        $centerX      = $centerX<0 ? 0 : $centerX;
        $centerY      = ceil(($height - $text_height) / 2) + 345;
        $centerY      = $centerY<0 ? 0 : $centerY;
        imagettftext($img, 18, 0, $centerX, $centerY, $white, $font, $txt);
        imagejpeg($img, 'assets/image/voucher/voucher_'.$voucher_name.'.jpg');
    }

    function get_color_name($id = ""){
        $ci =& get_instance();
        $query = $ci->db->get_where('color', array('ID_color' => $id))->row_array();
        return (!empty($query['ColorName'])) ? $query['ColorName'] : '';
    }

    function get_size_name($id = ""){
        $ci =& get_instance();
        $query = $ci->db->get_where('size', array('ID_size' => $id))->row_array();
        return (!empty($query['Size'])) ? $query['Size'] : '';
    }

    function barcode_from_sku($sku){
        $a   = substr(trim($sku), -16);
        $barcode = preg_replace('/[^-0-9]/', '', trim($a));
        $barcode = preg_split('/-/', $barcode,-1, PREG_SPLIT_NO_EMPTY);

        return $barcode;
    }
}