<?php 
/**
 * @Developer  Doeun
 * @Module   Site
 * @Descript Add,Edit,Update and select
 * @Company   Mapring
 * @copyright 2013
 */
class Application_Model_ModSite {
	public $TableSite = null;
	public $TableHirachySite =null;
	private $_tblRefCodes;
	/**Create contractor**/
	function __construct(){
	 $this->TableSite = new Application_Model_DbTable_Site();	
	 $this->TableHirachySite= new Application_Model_DbTable_HierarchieSite();
	 $this->_tblRefCodes = new Application_Model_DbTable_RefCodes ();
	}
	public function SelectRefComType() {
		$sql = $this->_tblRefCodes->select ()
		->from ( $this->_tblRefCodes, array (
				"ref_code_lib",
				"ref_Code",
				"ref_Id"
		) )->where ( "ref_Num=?", "SIT003" );
		$rows = $this->_tblRefCodes->fetchAll ( $sql )->toArray ();
		return (! empty ( $rows )) ? $rows : null;
	}
	public function SelectRefStatus() {
		$sql = $this->_tblRefCodes->select ()
		->from ( $this->_tblRefCodes, array (
				"ref_code_lib",
				"ref_Code",
				"ref_Id"
		) )->where ( "ref_Num=?", "SIT001" );
		$rows =$this->_tblRefCodes->fetchAll ( $sql )->toArray ();
		return (! empty ( $rows )) ? $rows : null;
	}
	public function SelectRefCode() {
		$sql = $this->_tblRefCodes->select ()
		->from ( $this->_tblRefCodes, array (
				"ref_code_lib",
				"ref_Code",
				"ref_Id"
		) )->where ( "ref_Num=?", "SIT002" );
		$rows =$this->_tblRefCodes->fetchAll ( $sql )->toArray ();
		return (! empty ( $rows )) ? $rows : null;
	}
	
	public function SelectRefLevel() {
		$sql = $this->_tblRefCodes->select ()
		->from ( $this->_tblRefCodes, array (
				"ref_code_lib",
				"ref_Code",
				"ref_Id"
		) )->where ( "ref_Num=?", "SIT004" );
		$rows = $this->_tblRefCodes->fetchAll ( $sql )->toArray ();
		return (! empty ( $rows )) ? $rows : null;
	}
	
	
    /**Starting Module adding to site**/
   public function InsertRecordToTableSite($DataSite){
   	try{
   	 $this->TableSite->insert ( $DataSite );
	 $LastIdInsert = $this->TableSite->getAdapter ()->lastInsertId ();
	 return $LastIdInsert;
    }catch (ErrorException $ex){
     	echo "Message:".$ex->getMessage();
     }
   }
   /**Ending Module adding to site**/
   /**Starting Module adding to Sub site**/
   public function InsertRecordToTableSubSite($DataSubsite){
   	try{
   	$this->TableHirachySite->insert($DataSubsite);
   	}catch (ErrorException $ex){
     	echo "Message:".$ex->getMessage();
     }
   }
   /**Ending Module adding to Sub site**/
   /*Starting delete site*/
   public function deleteSites($idSite){
   	try{
   		$idSitewhere = $this->TableSite->getAdapter ()->quoteInto ( 'site_Id = ?', $idSite );
   		$SiteDel = $this->TableSite->delete ( $idSitewhere );
   		
   		//$idSubSitewhere = $this->TableHirachySite->getAdapter ()->quoteInto ( 'site_Id = ?', $idSite );
   		//$SiteDel        =$this->TableHirachySite->delete ( $idSubSitewhere );
   		
   		if($SiteDel){
   			return true;
   		}else{
   			return false;
   		}
   	}catch(ErrorException $ex){
   		echo "Message:".$ex->getMessage();
   	}
   }
   /*Ending of delete site*/
   
   /*Starting multidelete site*/
   public function multiDeleteSite($idMultiDelSite){
   	  try{
   	  for($i=0;$i<count($idMultiDelSite);$i++){
   	  	$id= $idMultiDelSite[$i];
   	    $idSitewhere = $this->TableSite->getAdapter ()->quoteInto ( 'site_Id = ?', $id );
   	  	$this->TableSite->delete ( $idSitewhere );
   	  	$idSubSitewhere = $this->TableHirachySite->getAdapter ()->quoteInto ( 'site_Id = ?', $id );
   	  	$this->TableHirachySite->delete ( $idSubSitewhere );
   	  }
   	  return true;
   	 }catch (ErrorException $error){
   	 	echo "".$error->getMessage();
   	 }
   }
   /*Ending multidelete site*/
   /*Starting of Selecting all record from site for editing*/
   public function SelectAllFromSite($idForEditSite,$idusers){
   	try{
   		$db = Zend_Db_Table::getDefaultAdapter ();
   		$data=array("userid"=>"users.User_id");
           	$select = $db->select ()->from (array('sites'=>'Site') )
           	->joinInner (array('users'=>'CUser' ),'users.User_id = sites.User_id',$data )
            ->joinInner (array('com'=>'Company' ),'com.Com_Id = sites.Com_Id' )
            ->where('sites.site_Id=?',$idForEditSite)
            ->where('users.User_id=?',$idusers);
   		$rows = $db->fetchAll ($select);
   		return (!empty($rows))?$rows:null;
   	}catch (ErrorException $ex){
   		echo "Message:".$ex->getMessage();
   	}
   }
   /*Ending of Selecting all record from site for editing*/
   /*Starting update site module*/
   public function updateRecordSite($editSiteData,$id){
   	$idEdit=$this->TableSite->getAdapter()->quoteInto(' site_Id= ? ',$id) ;
   	$this->TableSite->update($editSiteData,$idEdit);
   }
   /*Ending update site module*/
   /*Starting update subsite*/
   public function UpdateRecordToTableSubSite($EditDataSubsite,$id){
   	$idEdit=$this->TableHirachySite->getAdapter()->quoteInto(' site_Id= ? ',$id) ;
   	$this->TableHirachySite->update($EditDataSubsite,$idEdit);
   }
   /*Ending update subsite*/
   /*Starting select view site module*/
   public function selectAllViewSiteModule(){
   	try{
   	$db = Zend_Db_Table::getDefaultAdapter ();
    $data=array("userid"=>"users.User_id");
   	$select = $db->select ()->from (array('sites'=>'Site') )
   	->joinInner (array('users'=>'CUser' ),'users.User_id = sites.User_id',$data )
    ->joinInner (array('com'=>'Company' ),'com.Com_Id = sites.Com_Id' )
    ->where('users.User_id=?',$_SESSION['UserId']);

   	$rows = $db->fetchAll ($select );
   	return (!empty($rows))?$rows:null;
     }catch (ErrorException $ex){
     echo "Message:".$ex->getMessage();
     }
   }
   
   /*Ending  select view site module*/
   /*Starting site overview*/
   public function selectSiteOverview($id,$userid){
       	try{
           	$db = Zend_Db_Table::getDefaultAdapter ();
            $data=array("userid"=>"users.User_id");
           	$select = $db->select ()->from (array('sites'=>'Site') )
           	->joinInner (array('users'=>'CUser' ),'users.User_id = sites.User_id',$data )
            ->joinInner (array('com'=>'Company' ),'com.Com_Id = sites.Com_Id' )
            ->where('sites.site_Id=?',$id)
            ->where('users.User_id=?',$userid);
           	$rows = $db->fetchAll ($select);
           	return (!empty($rows))?$rows:null;
             }catch (ErrorException $ex){
             echo "Message:".$ex->getMessage();
             }  
   }
   /*Ending site overview*/
   /*Starting select company*/
     public function selectCompanyName(){
          try{
                $db = Zend_Db_Table::getDefaultAdapter ();
                $select = $db->select ()->from (array('Com'=>'Company') );
                $rows = $db->fetchAll ($select );
                return (!empty($rows))?$rows:null;
          }catch (ErrorException $ex){
                echo "Message:".$ex->getMessage();
           }  
          
     }
   /*Ending select company*/
   
}
