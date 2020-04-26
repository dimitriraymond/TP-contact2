<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Helpers;

/**
 * Description of Database
 *
 * @author dimit
 */
class Database {
    
    /**
     * @var $instances de type Tableau. Cette variable va permettre de s’assurer qu’il n’y a qu’une instance de
     * connexion à la base de données (déjà vu ailleurs).
     */
    protected static $instances = array();

    /**
     * Méthode statique get 	→ la méthode est statique → pas d’instanciation de Database
     *
     * @param $config type Array → permet de récupérer les données de connexion et d’authentification de Config.
     * @return \helpers\database
     */
    public static function get($config)
    {
        // initialisation des attributs avec les données de la classe Config (namespace App\)
        $type = $config['db_type'];
        $host = $config['db_host’];
        $port = $config['db_port’];
        $name = $config['db_name'];
        $user = $config['db_username'];
        $pass = $config['db_password'];

        // ID de la connexion à la bdd créé à partir des données permet le test ci-après
        $id = "$type.$host.$name.$user.$pass";

        // Vérification de l’existence dans instance de la valeur contenue dans $id. Si vrai la connexion est déjà. 
        if (isset(self::$instances[$id])) {
            return self::$instances[$id];
        }
        // si pas de connexion on en crée une. Et la ligne suivante relève toute erreur

        $instance = new Database("$type:host=$host;port=$port;dbname=$name;user=$user;password=$pass");
        $instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Enregisrement de la connexion dans $instances pour éviter la duplication
        self::$instances[$id] = $instance;

        //retour de l’instance pdo
        return $instance;

    }
















Quelques noms de méthodes sont écrits en rouge → aller chercher dans la doc PHP et commenter le code.
    /**
     * exécute des requêtes sql sans vérification. => nécessite d’être sûr qu’il n’y a aucun problème de sécurité
     * @param  string $sql commande sql
     * @return none
     */
    public function raw($sql)
    {
       return $this->query($sql);
    }


    /**
     * methode d’extraction des enregistrements d’une bdd (SELECT)
     * @param  string $sql       requête sql
     * @param  array  $array     paramètres nommés
     * @param  object $fetchMode  (mode optionnel)
     * @param  string $class     nom de la classe en lien avec le fetchMode
     * @return array            retourne un tableau d’enregistrements
     */
    public function select($sql, $array = array(), $fetchMode = PDO::FETCH_OBJ, $class = '')
    {
         // Contrôle de la commande envoyée/commande attendue → si on ne reçoit pas ‘select’ on force à ‘SELECT’
          // on passe en minuscules et on vérifie les ce valent les 7 premiers caractères de la requête si on ne trouve
          // pas ‘select’ alors on ajoute ‘SELECT’ qu’on concatène à la requête reçue.
        if (strtolower(substr($sql, 0, 7)) !== 'select ') {
            $sql = "SELECT " . $sql;
        }

        // on crée une requête préparée. Avant son exécution on boucle dans la requête reçue de façon a affecté le type
         // correct → un type entier reçu sera typé PARAM_INT sinon le type utilisé sera une chaîne.
        $stmt = $this→prepare($sql);			// requête préparée → sécurité
        foreach ($array as $key => $value) {
            if (is_int($value)) {
                $stmt->bindValue("$key", $value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue("$key", $value);
            }
        }

        // la requête sql préparée est passée au serveur pour être exécutée. Par défaut un objet est retourné.
        $stmt->execute();

        if ($fetchMode === PDO::FETCH_CLASS) {			// l’opérateur ici contrôle la valeur et le type
            return $stmt->fetchAll($fetchMode, $class);		// on retourne un objet de la classe
        } else {
            return $stmt->fetchAll($fetchMode);
        }
    }


    /**
     * méthode insert
     * @param  string $table nom de la table
     * @param  array $data  tableau de colonnes et des valeurs
     */
    public function insert($table, $data)
    {
        ksort($data);

        $fieldNames = implode(',', array_keys($data));
        $fieldValues = ':'.implode(', :', array_keys($data));

        $stmt = $this->prepare("INSERT INTO $table ($fieldNames) VALUES ($fieldValues)");

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $this->lastInsertId();
    }


    /**
     * méthode update
     * @param  string $table nom de la table
     * @param  array $data  tableau des colonnes et des valeurs
     * @param  array $where tableau de colonnes et de valeurs
     */
    public function update($table, $data, $where)
    {
        ksort($data);

        $fieldDetails = null;
        foreach ($data as $key => $value) {
            $fieldDetails .= "$key = :$key,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');

        $whereDetails = null;
        $i = 0;
        foreach ($where as $key => $value) {
            if ($i == 0) {
                $whereDetails .= "$key = :$key";
            } else {
                $whereDetails .= " AND $key = :$key";
            }
            $i++;
        }
        $whereDetails = ltrim($whereDetails, ' AND ');

        $stmt = $this->prepare("UPDATE $table SET $fieldDetails WHERE $whereDetails");

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        foreach ($where as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->rowCount();
    }

    /**
     * méthode delete
     * @param  string $table nom de la table
     * @param  array $data  tableau de colonnes et de valeurs
     * @param  array $where tableau de colonnes et de valeurs
     * @param  integer $limit nombre limite d’enregistrements
     */
    public function delete($table, $where, $limit = 1)
    {
        ksort($where);

        $whereDetails = null;
        $i = 0;
        foreach ($where as $key => $value) {
            if ($i == 0) {
                $whereDetails .= "$key = :$key";
            } else {
                $whereDetails .= " AND $key = :$key";
            }
            $i++;
        }
        $whereDetails = ltrim($whereDetails, ' AND ');

        //if limit is a number use a limit on the query
        if (is_numeric($limit)) {
            $uselimit = "LIMIT $limit";
        }

        $stmt = $this->prepare("DELETE FROM $table WHERE $whereDetails $uselimit");

        foreach ($where as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->rowCount();
    }

    /**
     * truncate table
     * @param  string $table table name
     */
    public function truncate($table)
    {
        return $this->exec("TRUNCATE TABLE $table");
    }

    //put your code here
}
