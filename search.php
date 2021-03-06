<?php
/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 9/12/16
 * Time: 6:06 PM
 */

// DATA
$d[0] = "Shipment of gold damaged in a fire";
$d[1] = "Delivery of silver arrived in a silver truck";
$d[2] = "Shipment of gold arrived in a truck";
$d[3] = "Delivery and Shipment of gold arrived from a truck";

// QUERY
$q[0] = "gold silver truck";


// DATA PROCESSOR

$cs = new CosineSimilarity($d,$q);

// Show Result with Form as List
$tableShow = new ShowDisplay($cs);
$tableShow->TableShow();

// SHOW RESULT
$tableShow->TableShowResult();

?>

<?php

class ShowDisplay{

    protected $cs;
    protected $data_table;
    protected $data_show;
    protected $data_show_result;

    public function __construct($data_display){
        $args = func_get_args();

//        print_r($args);

        $cs = $data_display;
        $this->data_table = $data_display;

        $data_TransFunc =  $this->data_table->TF_each;
        $data_DF =  $this->data_table->DF;
        $data_DFi =  $this->data_table->DDFi;
        $data_IDF =  $this->data_table->idf;
        $data_WTI =  $this->data_table->w_tfidf;
        $data_DP =  $this->data_table->DotProd;
        $data_VL =  $this->data_table->VectorLength;

        $this->data_show_result =  $this->data_table->show_result;

        $this->data_show = array_merge_recursive($data_TransFunc, $data_DF, $data_DFi, $data_IDF, $data_WTI, $data_DP, $data_VL);

    }

    public function TableShow(){

        function print_row(&$item, $key) {
            echo('<tr>'.'<td>'.$key.'</td><td>'.implode('</td><td>', $item).'</td>'.'</tr>');
        }

        ?>

        <table border="0" width="90%" align="center">
        <tr>
            <th rowspan="2" bgcolor="#7fffd4">Word</th>
            <th colspan="<?php echo $this->data_table->num_d + 1; ?>" bgcolor="#ffebcd">Term Frequency</th>
            <th rowspan="2">DF</th>
            <th rowspan="2">D/DF</th>
            <th rowspan="2">idf</th>
            <th colspan="<?php echo $this->data_table->num_d + 1; ?>" bgcolor="#deb887">W = TFxIDF</th>
            <th colspan="<?php echo $this->data_table->num_d; ?>" bgcolor="#6495ed">q x d</th>
            <th colspan="<?php echo $this->data_table->num_d + 1; ?>" bgcolor="#9acd32">Vector Length</th>
        </tr>
        <tr>
            <th>q</th>
            <?php for ($i = 0; $i < $this->data_table->num_d; $i++) {
                echo '<th>d' . $i . '</th>';
            } ?>
            <th bgcolor="#ffebcd">q</th>
            <?php for ($i = 0; $i < $this->data_table->num_d; $i++) {
                echo '<th>d' . $i . '</th>';
            } ?>
            <?php for ($i = 0; $i < $this->data_table->num_d; $i++) {
                echo '<th>d' . $i . '</th>';
            } ?>
            <th>q</th>
            <?php for ($i = 0; $i < $this->data_table->num_d; $i++) {
                echo '<th>d' . $i . '</th>';
            } ?>
        </tr>
        <?php array_walk( $this->data_show, 'print_row'); ?>
        </table><?php
    }

    public function TableShowResult(){


        function print_list(&$item, $key) {
            echo('<ul>'.'<li>'.$key.'</li><li>'.implode('%</li><li>', $item).'%</li>'.'</ul>');
        }
        ?>

        <table border="1">
            <?php array_walk($this->data_table->show_result, 'print_list');?>
        </table>

        <?php
    }


}

class CosineSimilarity {

    private $str;
    public $words;
    public $num_d;

    protected $au;

    public $TF_each;
    public $TF_count;
    public $DF;
    public $DDFi;
    public $idf;
    public $w_tfidf;
    public $DotProd;
    public $VectorLength;
    public $length_vector;
    public $cos_sim;
    public $show_result;

    public function __construct($d,$q){

        $data = func_get_args();

        $this->num_d = sizeof($d);

        if (isset($data)){
            foreach ($data as $dt=>$a){
                foreach ($a as $b=>$c) {
                    $this->str[] = strtolower($c);
                }
            }
        }

        echo '<pre>';print_r($this->str);


        foreach (array_filter($this->str) as $arr){
            $this->words[] = preg_split('/((^\p{P}+)|(\p{P}*\s+\p{P}*)|(\p{P}+$))/', $arr, -1, PREG_SPLIT_NO_EMPTY);
        }

        $all_word = call_user_func('array_merge',$this->words);

        $flat = iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($all_word)), 0);

        // Array Unique
        $au = array_unique($flat);

        $this->au = $au;

// ==================================================== START HERE ==================================================
        // Script start
        $rustart = getrusage();

        // Code ...

        $countTF = $this->countTF($au,$this->words);

        $countDF = $this->countDF($this->TF_count);

        $countDDFi = $this->countDDFi($countDF);

        $countIDF = $this->countIDF($countDDFi);

        $countW_TFIDF = $this->countW_TFIDF($countTF, $countIDF);

        $countDP = $this->countDotProd();
        $countDP = $this->countVectorLength();
        $count_CS = $this->countCoSim();

        $this->showResult();

        // Script end
        function rutime($ru, $rus, $index) {
            return ($ru["ru_$index.tv_sec"]*1000 + intval($ru["ru_$index.tv_usec"]/1000))
            -  ($rus["ru_$index.tv_sec"]*1000 + intval($rus["ru_$index.tv_usec"]/1000));
        }

        $ru = getrusage();
        echo "This process used " . rutime($ru, $rustart, "utime") .
            " ms for its computations\n";
        echo "It spent " . rutime($ru, $rustart, "stime") .
            " ms in system calls\n";

    }

    public function nonzero($var){
        return ($var & 0);
    }
    /**
     * @param $key_word Array Uniq as Index
     * @param $arr_word Word
     * @return array
     */
    public function countTF($key_word, $arr_word){
        asort($key_word);

//      Remove Last Array from Word
//        array_pop($arr_word);

        $mtx_count_qr = [];
        $mtx_count_data = [];

        foreach ($key_word as $au_idx){
            $i = 0;
            foreach ($arr_word as $w_idx){
                if($i===$this->num_d){
                    $mtx_count_qr[$au_idx][] = count(array_keys($w_idx,$au_idx));
                } else {
                    $mtx_count_data[$au_idx][] = count(array_keys($w_idx,$au_idx));
                }

                $i++;
            }
        }

        $mtx_count = array_merge_recursive($mtx_count_qr,$mtx_count_data);

        function word_exist($number){
            // select not zero
            if(!($number > 0))return $number;
            return 1;

        }

        foreach ($mtx_count_data as $key => $val){
            foreach ($val as $k => $v){
                $new_mtx[$key] = array_map('word_exist', $val);
            }
        }

        if (!empty($mtx_count) && !empty($new_mtx)) {
            $this->TF_each = $mtx_count;
            $this->TF_count = $new_mtx;
        }

        return $mtx_count;

    }

    /**
     * @param $data
     * @return array|null
     */
    public function countDF($data){

        foreach($data as $k => $v) $result[$k] = array_sum($v);

        if(!empty($result)) {
            $this->DF = $result;
            return $result;
        }

        return null;
    }

    /**
     * @param $df
     * @return null
     */
    public function countDDFi($df){
        foreach($df as $k => $v) {

            $result[$k] = $this->num_d/$v;
        }

        if(!empty($result)) {
            $this->DDFi = $result;
            return $result;
        }
        return null;
    }

    /**
     * @param $ddfi
     * @return null
     */
    public function countIDF($ddfi){
        foreach($ddfi as $k => $v) $result[$k] = number_format((float)log($v,10),4);
        if(!empty($result)) {
            $this->idf = $result;
            return $result;
        }

        return null;
    }


    /**
     * @param $tf
     * @param $idf
     * @return null
     */
    public function countW_TFIDF($tf, $idf){
//      TODO

        foreach ($tf as $k => $v){
            for($i=0;$i<sizeof($v);$i++){
                $res[$k][] = $v[$i] * $idf[$k] ;
            }
        }

        if(!empty($res)) {
            $this->w_tfidf = $res;
            return $res;
        }

        return null;
    }

    /** Count DotProduct q * d
     * @return null
     */
    public function countDotProd(){

        foreach ($this->w_tfidf as $k => $v){
            for($i=1;$i<sizeof($v);$i++){
                $result[$k][] = $v[0]*$v[$i];
            }
        }

        if (!empty($result)) {
            $this->DotProd = $result;
        }

        return null;
    }


    public function countVectorLength(){

        foreach ($this->w_tfidf as $k => $v){
            $result[$k] = array_map(function ($var){ return (pow($var,2));}, $v);

        }
        if (!empty($result)) {
            $this->VectorLength = $result;
        }
        return null;

    }

    public function countCoSim(){

//      Initialization default value of array

        $sumDP = array_fill(0,$this->num_d, 0);
        $sumVL = array_fill(0,$this->num_d+1, 0);

        foreach ($this->DotProd as $k => $subArray) {
            foreach ($subArray as $v => $value) {
                $sumDP[$v]+=$value;
            }
        }

        foreach ($this->VectorLength as $k => $subArray) {
            foreach ($subArray as $v => $value) {
                $sumVL[$v]+=$value;
            }
        }

        $sqrt_sum = array_map(function($var){ return sqrt($var);}, $sumVL);

        foreach ($sumDP as $item => $val) {
//            $cossim[] = $val / ($sqrt_sum[0]*$sqrt_sum[$item+1])*100;
            $cossim[] = number_format($val / ($sqrt_sum[0]*$sqrt_sum[$item+1])*100, 2);
//        number_format((float)log($v,10),4)
        }

        if (!empty($cossim)) {
            foreach ($cossim as $k => $v){
                $rank[] = $v;
            }
            // Sort Result Ascending
            arsort($rank, SORT_NUMERIC);

            $this->cos_sim = $rank;

        }

        return null;

    }

    public function showResult(){

        foreach ($this->cos_sim as $k => $v){
                $resultShow[$k] = [$v,$this->str[$k]];
        }

        if (!empty($resultShow)) {
            $this->show_result = $resultShow;
//            print_r($resultShow);
        }

        return null;
    }

    public function nested_foreach($i){

        if(count($i)>1 && $i!=null){
            echo "<pre>count i =";
//            print_r(count($i));
            echo count($i);

            foreach ($i as $a=>$b){
                $this->nested_foreach($b);
            }
        } else {
            echo "<pre>";
            print_r(count($i));
            echo "</pre>";
            $strtemp[] = $i;
        }
        return $strtemp;
    }

    /**
     * @return mixed
     */
    public function getTF()
    {
        return $this->TF_each;
    }

    /**
     * @return mixed
     */
    public function getDF()
    {
        return $this->DF;
    }

    /**
     * @return mixed
     */
    public function getDDFi()
    {
        return $this->DDFi;
    }

    /**
     * @return mixed
     */
    public function getW_TFIDF()
    {
        return $this->w_tfidf;
    }

    /**
     * @return mixed
     */
    public function getDotProd()
    {
        return $this->DotProd;
    }

    /**
     * @param mixed $DotProd
     */
    public function setDotProd($DotProd)
    {
        $this->DotProd = $DotProd;
    }

    /**
     * @param mixed
     */
    public function getVectorLength()
    {
        return $this->VectorLength;
    }

    /**
     * @param mixed $vectorLength
     */
    public function setVectorLength($vectorLength)
    {
        $this->VectorLength = $vectorLength;
    }

// ================================================>

    /**
     * @return mixed
     */
    public function getIdf()
    {
        return $this->idf;
    }

    /**
     * @param mixed $idf
     */
    public function setIdf($idf)
    {
        $this->idf = $idf;
    }

    /**
     * @return mixed
     */
    public function getWTfidf()
    {
        return $this->w_tfidf;
    }

    /**
     * @param mixed $w_tfidf
     */
    public function setWTfidf($w_tfidf)
    {
        $this->w_tfidf = $w_tfidf;
    }

    /**
     * @return mixed
     */
    public function getLengthVector()
    {
        return $this->length_vector;
    }

    /**
     * @param mixed $length_vector
     */
    public function setLengthVector($length_vector)
    {
        $this->length_vector = $length_vector;
    }

    /**
     * @return mixed
     */
    public function getCosSim()
    {
        return $this->cos_sim;
    }

    /**
     * @param mixed $cos_sim
     */
    public function setCosSim($cos_sim)
    {
        $this->cos_sim = $cos_sim;
    }

    /**
     * @return mixed
     */
    public function getShowResult()
    {
        return $this->show_result;
    }

    /**
     * @param mixed $show_result
     */
    public function setShowResult($show_result)
    {
        $this->show_result = $show_result;
    }

}



//Input:
//Array
//(
//    [a] => Array
//    (
//        [0] => 1
//            [1] => 1
//            [2] => 1
//            [3] => 0
//        )
//
//    [b] => Array
//(
//    [0] => 0
//            [1] => 1
//            [2] => 1
//            [3] => 0
//        )
//)
//
//Output:
//Array
//    (
//        [a] => 2
//            [b] => 3
//)
//
//foreach($input as $k => $v)
//    $result[$k] = array_sum($v)