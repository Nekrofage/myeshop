<?php 

class AI_Administration
{

    /*
       Create Sql user
       Only mysql admin can do that.
     */

    public static function createSqlUser($user, $password){
        $conn = new mysqli("localhost", "root", "mot2passe");

        if (mysqli_connect_errno()) {
            exit('Connection failed'. mysqli_connect_error());
        }

        //$sql = "use mysql;drop user '" . $user . "'@'localhost';flush privileges;CREATE USER '" . $user . "'@'localhost' IDENTIFIED BY '" . $password . "';";
        $sql = "USE mysql;";
        if ($conn->query($sql) === TRUE) {
            echo "Use mysql database<br/>";
        } else {
            echo "Error: " . $conn->error . "<br/>";
        }

        $sql = "DROP USER '" . $user . "'@'localhost';";
        if ($conn->query($sql) === TRUE) {
            echo "Drop user " . $user . "<br/>";
        } else {
            echo "Error: " . $conn->error . "<br/>";
        }

        $sql = "FLUSH PRIVILEGES;";
        if ($conn->query($sql) === TRUE) {
            echo "Flush privileges<br/>";
        } else {
            echo "Error: " . $conn->error . "<br/>";
        }

        $sql = "CREATE USER '" . $user . "'@'localhost' IDENTIFIED BY '" . $password . "';";

        if ($conn->query($sql) === TRUE) {
            echo "Create user '" . $user . "'@'localhost'<br/>";
        } else {
            echo "Error: " . $conn->error . "<br/>";
        }
    }

    /*
       Create user database
       Only mysql admin can do that.
     */

    public static function createUserDatabase($user){

        $conn = new mysqli("localhost", "root", "mot2passe");

        if (mysqli_connect_errno()) {
            exit('Connection failed'. mysqli_connect_error());
        }

        $sql = "CREATE DATABASE `$user`;";

        if ($conn->query($sql) === TRUE) {
            echo "User Database created: " . $user . "<br/>";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    /*
       Set permission user database
       Only mysql admin can do that.
     */

    public static function setPermissionUserDatabase($user, $password){


        $conn = new mysqli("localhost", "root", "mot2passe");

        if (mysqli_connect_errno()) {
            exit('Connection failed'. mysqli_connect_error());
        }
        $sql = "GRANT ALL PRIVILEGES ON `$user`.* TO '$user'@'localhost';";

        if ($conn->query($sql) === TRUE) {
            echo "User Permission Database created: " . $user . "<br/>";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    /*
       Remove user database
       Only mysql admin can do that
     */

    public static function removeUserDatabase($user){


        $conn = new mysqli("localhost", "root", "mot2passe");

        if (mysqli_connect_errno()) {
            exit('Connection failed: '. mysqli_connect_error());
        }

        $sql = "DROP DATABASE " . $user . ";";

        if ($conn->query($sql) === TRUE) {
            echo "User Database removed " . $user . "<br/>";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    /*
       Remove software database by user
     */

    public static function removeSoftwareTables($user, $password, $software){
        $conn = new mysqli("localhost", $user, $password);
        if (mysqli_connect_errno()) {
            exit('Connection failed'. mysqli_connect_error());
        }

        $sql = "USE " . $user . ";";

        if ($conn->query($sql) === TRUE) {
            echo "Database selected: " . $user . "<br/>";
        } else {
            echo "Error: " . $conn->error;
        }

        $sql = "SHOW tables FROM " . $user;

        if ($result = $conn->query($sql)) {
            while ($row = $result->fetch_row()) {
                $sql1 = "DROP TABLE " . $row[0];
                if ($conn->query($sql1) === TRUE) {
                    echo "Table deleted: " . $row[0] . "<br/>";
                } else {
                    echo "Error: " . $conn->error;
                }
            }
            $result->close();
        }
    }

    /*
       Remove User in database	
     */
    public static function removeUserInDatabase($user, $password){


        $conn = new mysqli("localhost", "root", "mot2passe");

        if (mysqli_connect_errno()) {
            exit('Connection failed: '. mysqli_connect_error());
        }

        $sql = "DELETE FROM `mysql`.`user` WHERE `user`.`User` =  '" . $user . "';";

        if ($conn->query($sql) === TRUE) {
            echo "User Database in Database removed " . $user . "<br/>";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    /*
       Remove UserDatabase in database
     */
    public static function removeUserDatabaseInDatabase($user, $password){

        $conn = new mysqli("localhost", "root", "mot2passe");

        if (mysqli_connect_errno()) {
            exit('Connection failed: '. mysqli_connect_error());
        }

        $sql = "DELETE FROM `mysql`.`db` WHERE `db`.`Db` = '" . $user . "' AND `db`.`User` =   '" . $user . "';";

        if ($conn->query($sql) === TRUE) {
            echo "Database removed " . $user . "<br/>";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    /*
       Create user
     */
    public static function createUser($user, $password){
        createUserSite($user);
        createSqlUser($user, $password);
        createUserDatabase($user);
        setPermissionUserDatabase($user, $password);
    }

    /*
       Create user site
     */
    public static function createUserSite($user){
        echo "Create '$user' UserSite <br/>";
        @mkdir($user);
    }

    /*
       Delete user site
     */

    public static function deleteUserSite($usersite){
        rmdir($usersite);       
    }

    /*
       Delete software
     */

    public static function deleteSoftware($software) {	
        if (is_dir ($software)) {
            $dh = opendir ($software); 
        }else {     
            exit;
        }

        while (($file = readdir ($dh)) !== false ) { 
            if ($file !== '.' && $file !== '..') { 
                $path = $software.'/'.$file;
                if (is_dir ($path)) {           
                    AI_Administration::deleteSoftware($path); 
                    rmdir($path);
                }else {   
                    unlink($path);
                }
            }
        }
        closedir ($dh); 
    }

    /*
       Desactivate user site
     */
    public static function activateUserSite($user){
    }
}

?>
