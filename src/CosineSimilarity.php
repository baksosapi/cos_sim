<?php

/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 10/1/16
 * Time: 10:20 PM.
 *
 * @property array str
 * @property array words
 */
class CosineSimilarity
{
    //    private $str;
//    public $words;
//    public $num_d;

//    protected $au;

//    public $TF_each;
//    public $TF_count;
//    public $DF;
//    public $DDFi;
//    public $idf;
//    public $w_tfidf;
//    public $DotProd;
//    public $VectorLength;
//    public $length_vector;
//    public $cos_sim;

//    protected $show_result;

//    public function __construct($d,$q){

    public function __construct($q, $d)
    {
        $data_all = func_get_args();

        $data = array_merge_recursive($q,$d);

//        print_r($data_all);

        $this->num_q = count($q);
        $this->num_d = count($d);
        $this->num_data = count($data);

//        echo '<pre>';
//        print_r($this->num_q);
//        echo '<pre>';
//        print_r($this->num_d);
//        echo '<pre>';
//        print_r($this->num_data);

//        print_r(sizeof($data));
//        print_r($data);

//        Tokenization
        if (isset($data)) {
            foreach ($data as $key => $val) {
                    $this->str[] = strtolower($val);
            }
        }
//  q[] data[]
//        if (isset($data)) {
//            foreach ($data as $dt => $a) {
////                echo '<pre>';print_r($data);
//                foreach ($a as $b => $c) {
//                    $this->str[] = strtolower($c);
//                }
//            }
//        }
//
//        echo '<pre>';print_r($this->str);

        foreach (array_filter($this->str) as $arr) {
            $this->words[] = preg_split('/((^\p{P}+)|(\p{P}*\s+\p{P}*)|(\p{P}+$)|(\p{P}))/', $arr, -1, PREG_SPLIT_NO_EMPTY);
        }

        $all_word = call_user_func('array_merge', $this->words);

        $flat = iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($all_word)), 0);

        // Array Unique
        $au = array_unique($flat);

        $this->au = $au;


// ==================================================== START HERE ==================================================

        // Script start
        $rustart = getrusage();

        // Code ...

        $countTF = $this->countTF($au, $this->words);


        $countDF = $this->countDF($this->TF_count);

        $countDDFi = $this->countDDFi($countDF);

        $countIDF = $this->countIDF($countDDFi);

        $countW_TFIDF = $this->countW_TFIDF($countTF, $countIDF);

        $countDP = $this->countDotProd();

        $countVL = $this->countVectorLength();

        $count_CS = $this->countCoSim();

        $this->showResult();

        // Script end

// ==================================================== END MAIN JOB , HERE ==================================================

        function rutime($ru, $rus, $index)
        {
            return ($ru["ru_$index.tv_sec"] * 1000 + intval($ru["ru_$index.tv_usec"] / 1000))
            - ($rus["ru_$index.tv_sec"] * 1000 + intval($rus["ru_$index.tv_usec"] / 1000));
        }

        $ru = getrusage();

        echo 'Proses memerlukan waktu selama '.rutime($ru, $rustart, 'utime').
            ' ms untuk komputasi keseluruhan <br>';
        echo 'Proses pemanggilan '.rutime($ru, $rustart, 'stime').
            ' ms dalam Sistem Call <br>';
    }

    public function preview($var)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }

    public function nonzero($var)
    {
        return $var & 0;
    }

    public function division($a, $b)
    {
        if ($b == 0) {
            return;
        }

        return $a / $b;
    }

    /**
     * @param $key_word Array Uniq as Index
     * @param $arr_word Word
     *
     * @return array
     */
    public function countTF($key_word, $arr_word)
    {
        //        Sort Ascending of Key word (uniq words)
        asort($key_word);

//      Remove Last Array from Word
//        array_pop($arr_word);

//        $mtx_count_qr = [];

        $mtx_count_data = [];

        foreach ($key_word as $au_idx) {
            $i = 0;
//            $au_idx = strval($au_idx);

//            TODO: Focus here!!!
//          The trick, manipulate Numeric with adding a 'dot'
            if (is_numeric($au_idx)) {
                $au_idx = '.'.$au_idx;
            }

            $w = (strpos($au_idx, '.') === 0) ? substr($au_idx, 1) : $au_idx;

            foreach ($arr_word as $w_idx) {
                if ($i === 0) {
                    $mtx_count_qr[$au_idx][] = count(array_keys($w_idx, $w));
                } else {
                    $mtx_count_data[$au_idx][] = count(array_keys($w_idx, $w));
                }

//              Get All Words Stats
                $mtx_count_word[$au_idx][] = count(array_keys($w_idx, $w));

                $i++;
            }
        }

//      TODO: size array not compatible
//        $mtx_count_each_d = array_merge_recursive($mtx_count_qr,$mtx_count_data);

        if (!empty($mtx_count_word)) {
            $mtx_count_each_d = $mtx_count_word;
        }

        function word_exist($number)
        {
            // select not zero
            if (!($number > 0)) {
                return $number;
            }

            return 1;
        }

//        Count Data Only
        foreach ($mtx_count_data as $key => $val) {
            foreach ($val as $k => $v) {
                $mtx_count_all_d[$key] = array_map('word_exist', $val);
            }
        }

        if (!empty($mtx_count_each_d) && !empty($mtx_count_all_d)) {
            //          For display purpose
            $this->TF_each = $mtx_count_each_d;
//          For count purpose
            $this->TF_count = $mtx_count_all_d;
        }

//        echo 'matrix :<pre>';print_r($mtx_count_each_d);
//        echo 'matrix :<pre>';print_r(sizeof($mtx_count_all_d));

        return $this->TF_each;
    }

    /**
     * @param $data
     *
     * @return array|null
     */
    public function countDF($data)
    {
        foreach ($data as $k => $v) {
            $result[$k] = array_sum($v);
        }

        if (!empty($result)) {
            $this->DF = $result;

            return $result;
        }
    }

    /**
     * @param $df
     *
     * @return null
     */
    public function countDDFi($df)
    {
        //       Get Input from Data Frequency
        foreach ($df as $k => $v) {
            //          Check divisor is 0
            if ($v === 0) {
                $result[$k] = null;
            } else {
                $result[$k] = number_format((float) $this->num_d / $v, 4) + 0;
            }
        }

//        $this->preview($result);

        if (!empty($result)) {
            $this->DDFi = $result;

            return $result;
        }
    }

    /**
     * @param $ddfi
     *
     * @return null
     */
    public function countIDF($ddfi)
    {
        foreach ($ddfi as $k => $v) {
            $result[$k] = number_format((float) log($v, 10), 4) + 0;
        }
        if (!empty($result)) {
            $this->idf = $result;

            return $result;
        }
    }

    /**
     * @param $tf
     * @param $idf
     *
     * @return null
     */
    public function countW_TFIDF($tf, $idf)
    {
        //      TODO

//        echo '<pre>';print_r($tf);

        foreach ($tf as $k => $v) {
            for ($i = 0; $i < count($v); $i++) {
                //                TODO : undefined offset 0 3 4 5
//                echo '<pre>';print_r(gettype($k));
//                echo '<pre>';print_r($v);
//                if(is_integer($k)){
//                    $k = strval($k);
//                }
//                sprintf("%0.2f",$a)
                $res[$k][] = number_format((float) $v[$i] * $idf[$k], 4, '.', '') + 0;
//                $res[$k][] = sprintf("%0.2f", number_format((float) $v[$i] * $idf[$k], 4) );
            }
        }

        if (!empty($res)) {
            $this->w_tfidf = $res;

            return $res;
        }
    }

    /** Count DotProduct q * d
     * @return null
     */
    public function countDotProd()
    {
        foreach ($this->w_tfidf as $k => $v) {
            for ($i = 1; $i < count($v); $i++) {
                $result[$k][] = $v[0] * $v[$i];
            }
        }

        if (!empty($result)) {
            $this->DotProd = $result;
        }
    }

    public function countVectorLength()
    {
        foreach ($this->w_tfidf as $k => $v) {
            $result[$k] = array_map(function ($var) {
                return number_format(pow($var, 2), 4) + 0;
            }, $v);
        }
        if (!empty($result)) {
            $this->VectorLength = $result;
        }
    }

    public function countCoSim()
    {

//      Initialization default value of array

        $sumDP = array_fill(0, $this->num_d, 0);
        $sumVL = array_fill(0, $this->num_d + 1, 0);

        foreach ($this->DotProd as $k => $subArray) {
            foreach ($subArray as $v => $value) {
                $sumDP[$v] += $value;
            }
        }

        foreach ($this->VectorLength as $k => $subArray) {
            foreach ($subArray as $v => $value) {
                $sumVL[$v] += $value;
            }
        }

        $sqrt_sum = array_map(function ($var) {
            return sqrt($var);
        }, $sumVL);

        foreach ($sumDP as $item => $val) {

//          TODO :  potentially division by zero, solved.

            $cossim[] = number_format($this->division($val, ($sqrt_sum[0] * $sqrt_sum[$item + 1]) * 100), 16);
        }

        if (!empty($cossim)) {
            foreach ($cossim as $k => $v) {
                $rank[] = $v;
            }

            // Sort Result Ascending
            arsort($rank, SORT_NUMERIC);

            $this->cos_sim = $rank;

        }

//        $this->preview($this->cos_sim);
    }

    /** Display Result as
     * @return null
     */
    public function showResult()
    {

        array_shift($this->str);

        if (isset($this->cos_sim)) {
            foreach ($this->cos_sim as $k => $v) {
                $resultShow[$k] = [$v, $this->str[$k]];
            }
        }

        if (!empty($resultShow)) {

            $this->show_result = $resultShow;
        }
    }

//    =========================================== OPTIONAL TO USE =======================================
    public function nested_foreach($i)
    {
        if (count($i) > 1 && $i != null) {
            echo '<pre>count i =';
//            print_r(count($i));
            echo count($i);

            foreach ($i as $a => $b) {
                $this->nested_foreach($b);
            }
        } else {
            echo '<pre>';
//            print_r(count($i));
            echo '</pre>';
            $strtemp[] = $i;
        }

        if (isset($strtemp)) {
            return $strtemp;
        }
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
        if (!empty($this->show_result)) {
            return $this->show_result;
        }
    }

    /**
     * @param mixed $show_result
     */
    public function setShowResult($show_result)
    {
        $this->show_result = $show_result;
    }
}
