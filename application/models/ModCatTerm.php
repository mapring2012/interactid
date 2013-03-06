<?php
class Application_Model_ModCatTerm {
    public $GetTableTerm            = null;
    public $TermRelationships       = null;
    public $CatTermTaxonomy         = null;
    
	public function __construct() {
        $this->GetTableTerm         = new Application_Model_DbTable_CatTerm();
        $this->CatTermTaxonomy      = new Application_Model_DbTable_CatTermTaxonomy();
        
    }
    
    public function insertcat($insertCat){        
       $this->GetTableTerm->insert($insertCat);
   	    $insertID = $this->GetTableTerm->getAdapter()->lastInsertId();
		return $insertID;        
    }
    
        //insert into CatTermTaxonomy table
    public function insertTax ($insertTax)
    {
        $this->CatTermTaxonomy->insert($insertTax);
    }
    public function showCateAll()
    {
   	    $db = Zend_Db_Table::getDefaultAdapter ();
        $select = $db->select ()->from ( array ('tax' => 'CatTermTaxonomy' ))
        ->joinInner ( array ('term' => 'CatTerm' ), 'tax.term_id = term.term_id' )
        ->where ( 'parent=?', '0' );
		$rows = $db->fetchAll ( $select );
        return $rows;
    }

    public function showCateInList()
    {
        foreach ($this->showCateAll() as $row)
        {
            $id = $row['term_id'];            
            $db = Zend_Db_Table::getDefaultAdapter ();
            $select = $db->select ()->from ( array ('tax' => 'CatTermTaxonomy' ))
            ->joinInner ( array ('term' => 'CatTerm' ), 'tax.term_id = term.term_id' )->where ( 'parent=?', $id );
    		$row = $db->fetchAll ( $select );
            foreach ($row as $value)
            {
                
            }
            $menu_array[$row['term_id']] = array('term_id' => $row['term_id'],'name' => $row['name'],'parent' => $row['parent'],'image' => $row['image']);
            return $row;
        }   	    
       
    }
    
    public function showInParent($parentId)
    {
   	    $db = Zend_Db_Table::getDefaultAdapter ();
        $select = $db->select ()->from ( array ('tax' => 'CatTermTaxonomy' ))
        ->joinInner ( array ('term' => 'CatTerm' ), 'tax.term_id = term.term_id' )
        ->where ( 'parent=?', $parentId )->where( 'tax.taxonomy=?', 'category' );
		$rows = $db->fetchAll ( $select );
		return $rows;        
    }

    
    public function showCateParent($parent_id)
    {
   	    $db = Zend_Db_Table::getDefaultAdapter ();
        $select = $db->select ()->from ( array ('term' => 'CatTerm'))
         ->joinInner (array ('tax' => 'CatTermTaxonomy' ), 'tax.term_id = term.term_id' )
        ->where ( 'slug=?', $parent_id ) ->where ( 'parent=?',0 );
		$rows = $db->fetchAll ( $select );
        foreach ($rows as $row)
        {
            $row=$this->showInParent($row['term_id']);
        }
        return $row; 
    }
    

}