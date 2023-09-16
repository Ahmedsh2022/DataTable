<?php
class Database
{
    protected $link, $result, $numrows;
    public function __construct()
    {
        $this->link = mysqli_connect("localhost", "root", "", "project3");
        mysqli_set_charset($this->link, 'utf8');
    }

    public function disconnect()
    {
        mysqli_close($this->link);
    }

    //Query
    public function dbQuery($query)
    {
        $this->result = mysqli_query($this->link, $query);
        return $this->result;
    }

    //return NumRows
    public function dbNumRows()
    {
        return mysqli_num_rows($this->result);;
    }

    //FetchRecord
    public function dbFetchRecord($result)
    {
        return mysqli_fetch_array($this->result);
    }

    //fetch Row
    public function dbFetchArray($result)
    {
        $rows = array();
        for ($i = 0; $i < $this->dbNumRows(); $i++) {
            $rows[$i] = mysqli_fetch_assoc($this->result);
        }
        return $rows;
    }

    public function doLogin()
    {
        $errorMasseage = '';
        $username = $_POST['txtUserName'];
        $password = $_POST['txtPassword'];
        if ($username != '' && $password != '') {
            $query = "SELECT * FROM `accounts_tbl` WHERE login='$username' AND password='$password'";
            $result = $this->dbQuery($query);
            if ($this->dbNumRows() > 0) {
                $row = $this->dbFetchRecord($result);
                $_SESSION['id'] = $row[0];
                $_SESSION['name'] = $username;
                $_SESSION['is_login'] = true;
                header('location:index.php');
            } else
                $errorMasseage = 'الرجاء التحقق من اسم المستخدم او كلمة المرور';
        } else
            $errorMasseage = 'الرجاء ادخال اسم المستخدم او كلمة المرور';
        return $errorMasseage;
    }



    public function CheckUser()
    {
        if (isset($_SESSION['id']) && !$_SESSION['is_login']) {
            header('Location:login.php');
        } else {
            header('Location:index.php');
        }
    }
}
