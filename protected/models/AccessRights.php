<?php

/*
 * @author : owliber
 * @date : 2014-03-28
 */

class AccessRights extends CFormModel
{
    private $_connection;
    
    public function __construct() {
        $this->_connection = Yii::app()->db;
    }
    
    public function checkUserAccess($account_type_id)
    {
        $conn = $this->_connection;
        
        $link = $this->getControllerAction();
        
        $query = "SELECT
                    *
                  FROM access_rights ar
                    INNER JOIN menus m
                      ON ar.menu_id = m.menu_id
                    LEFT JOIN submenus s ON ar.submenu_id = s.submenu_id
                  WHERE (m.menu_link = :link OR s.submenu_link =:link)
                  AND ar.account_type_id = :account_type_id
                  AND m.status = 1";
        
        $command = $conn->createCommand($query);
        $command->bindParam(":account_type_id", $account_type_id);
        $command->bindParam(":link", $link);
        $result = $command->queryAll();
              
        if(count($result)>0)
            return true;
        else
            return false;
         
    }


    public function getMenus($account_type_id)
    {
        $conn = $this->_connection;
        
        $query = "SELECT
                    DISTINCT
                      (m.menu_id),
                      m.menu_name,
                      m.menu_link,
                      m.menu_icon,
                      m.menu_fkey,
                      m.css_class,
                      ar.default_menu_id,
                      m.status
                    FROM access_rights ar
                      INNER JOIN menus m
                        ON ar.menu_id = m.menu_id
                    WHERE ar.account_type_id = :account_type_id
                    AND m.status = 1
                    ORDER BY ar.menu_order;";
        
        $command = $conn->createCommand($query);
        $command->bindParam(":account_type_id", $account_type_id);
        $result = $command->queryAll();
              
        return $result; 
        
    }
    
    public function getSubMenus($menu_id, $account_type_id)
    {
        $conn = $this->_connection;
        
        $query = "SELECT
                DISTINCT
                  (sm.submenu_id),
                  ar.menu_id,
                  sm.submenu_name,
                  sm.submenu_link,
                  sm.status
                FROM access_rights ar
                  INNER JOIN submenus sm
                    ON ar.submenu_id = sm.submenu_id
                WHERE ar.account_type_id = :account_type_id
                AND ar.menu_id = :menu_id  
                AND sm.status = 1
                ORDER BY ar.sort_order;";
        
        $command = $conn->createCommand($query);
        $command->bindParam(":account_type_id", $account_type_id);
        $command->bindParam(":menu_id", $menu_id);
        $result = $command->queryAll();
              
        return $result; 
        
    }
    
    public function getAllMenus()
    {
        $conn = $this->_connection;
        
        $query = "SELECT
                m.menu_id,
                m.menu_name,
                m.menu_link,
                m.menu_icon,
                m.menu_fkey,
                m.css_class,
                m.status
              FROM menus m
              WHERE m.status = 1;";
        
        $command = $conn->createCommand($query);
        $result = $command->queryAll();
              
        return $result; 
    }
    
    public function getAllSubMenus($menu_id)
    {
        $conn = $this->_connection;
        
        $query = "SELECT
                sm.submenu_id,
                sm.menu_id,
                sm.submenu_name,
                sm.submenu_link,
                sm.status
              FROM submenus sm
                INNER JOIN menus m
                  ON sm.menu_id = m.menu_id
              WHERE sm.menu_id = :menu_id
              AND sm.status = 1;";
        
        $command = $conn->createCommand($query);
        $command->bindParam(":menu_id", $menu_id);
        $result = $command->queryAll();
              
        return $result; 
    }


    public function getControllerAction()
    {
        return Yii::app()->controller->getUniqueId() .'/'. Yii::app()->controller->action->id;
    }
    
}
?>
