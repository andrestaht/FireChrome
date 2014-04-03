<?php
class Search_results_model extends CI_Model {

	private $name = 'news';

    /**
    *Funktsioon, mis otsib andmebaasist etteantud sõne järgi tulemusi.
    *Tagastab uudise id ja pealkirjade listi.
    */
    public function search_news($string){
        $added = array();
        $search_result = array();
        $query = $this->db->query('SELECT title, id FROM news');
        foreach ($query->result_array() as $row) {
            if (strpos($row['title'], $string) !== false) { //And is visible ka siia panna?   
                array_push($added, $row['id']);//Et ei tekiks kordusi!    
                array_push($search_result, $row['id']);
            }
        }  
        $bool = false;
        $query = $this->db->query('SELECT content, id, title FROM news');
        foreach ($query->result_array() as $row) {
            if (strpos($row['content'], $string) !== false) { //And is visible ka siia panna? 
                foreach($added as $rows) {
                    if ($row['id'] == $rows) {
                        $bool = true;
                    }
                }
                if ($bool == false) {
                    array_push($search_result, $row['id']);
                }   
            }
        }
        return $search_result;
    }
}