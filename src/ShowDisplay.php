<?php

/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 10/2/16
 * Time: 2:13 AM
 */
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
