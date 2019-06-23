<?php


namespace Model;


class CustomerDB
{
    private $table_name = "customers";
    public $connection;
    public function __construct($connection)
    {
        $this->connection =$connection;
    }
    public function create($obj){
        $sql = "INSERT INTO
                    " . $this->table_name . "
                SET
                    name=:name, email=:email, address=:address";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":name", $obj->name);
        $statement->bindParam(":email", $obj->email);
        $statement->bindParam(":address", $obj->address);
        if($statement->execute()){
            echo "product created";
        }else{
            echo "false";
        }
        return $statement->execute();
    }
    public function getAll()
    {
        $sql = "SELECT * FROM customers";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $customers = [];
        foreach ($result as $row) {
            $customer = new Customer($row['name'], $row['email'], $row['address']);
            $customer->id = $row['id'];
            $customers[] = $customer;
        }
        return $customers;
    }
    public function get($id){
        $sql = "SELECT * FROM customers WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(1, $id);
        $statement->execute();
        $row = $statement->fetch();
        $customer = new Customer($row['name'], $row['email'], $row['address']);
        $customer->id = $row['id'];
        return $customer;
    }
    public function delete($id){
        $sql = "DELETE FROM customers WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(1, $id);
        return $statement->execute();
    }
    public function update($id, $customer){
        $sql = "UPDATE customers SET name = ?, email = ?, address = ? WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(1, $customer->name);
        $statement->bindParam(2, $customer->email);
        $statement->bindParam(3, $customer->address);
        $statement->bindParam(4, $id);
        return $statement->execute();
    }
}