<?php
class M_home extends CI_Model{

    function __construct()
	{
		parent::__construct();
		$this->load->database();
    }

    public function getAllNamaAkun()
    {
        $query=$this->db->get('jenisakun');
        $this->db->where('status', '1');

        $jenisakun = array();
        foreach($query->result_array() as $row)
        {
            $jenisakun[$row['id']]=$row['nama'];
        }

        $this->db->order_by('id_jenisAkun', 'ASC');
        $queryNA = $this->db->get('namaakun');

        $jsondata='{';
        $x=0;
        $y=0;
        $idJA = 0;
        foreach($queryNA->result_array() as $row)
        {
            if($idJA != $row['id_jenisAkun'])
            {
                $y=0;
                $idJA = $row['id_jenisAkun'];
                if($x>0)
                {
                    $jsondata = $jsondata.'],';
                }

                $jsondata = $jsondata.'"'.$jenisakun[$row['id_jenisAkun']].'":[';
                
                $x++;
            }

            if($y>0)
            {
                $jsondata = $jsondata.',';
            }

            $jsondata = $jsondata.'{"id":"'.$row['id'].'", "akun":"'.$row['nama'].'"}';

            $y++;
        }

        $jsondata = $jsondata.']}';

        return $jsondata;
    }

}
?>