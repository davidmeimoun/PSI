<?php

namespace GestionnaireLivret\DAO;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use GestionnaireLivret\Domain\User;

class UserDAO extends DAO implements UserProviderInterface
{
    
    
        /**
     * Returns a list of all users, sorted by role and name.
     *
     * @return array A list of all users.
     */
    public function findAll() {
        $sql = "select * from LIVRET_PERSONNEL order by usr_role, nom";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['ID_LIV_PERS'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }
    
    
    /**
     * Returns a user matching the supplied id.
     *
     * @param integer $id The user id.
     *
     * @return \MicroCMS\Domain\User|throws an exception if no matching user is found
     */
    public function find($id) {
        $sql = "select * from LIVRET_PERSONNEL where ID_LIV_PERS=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row){
             return $this->buildDomainObject($row);
        }
        else{
            throw new \Exception("No user matching id " . $id);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username)
    {
        $sql = "select * from LIVRET_PERSONNEL where USR_NAME=?";
        $row = $this->getDb()->fetchAssoc($sql, array($username));

        if ($row){
             return $this->buildDomainObject($row);
        }
        else{
         throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));   
        }
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }
        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return 'GestionnaireLivret\Domain\User' === $class;
    }
    
        /**
     * Saves a user into the database.
     *
     * @param \MicroCMS\Domain\User $user The user to save
     */
    public function save(User $user) {
        // Information souvant manquante dans la table Personnel(Teacher)
        if($user->getEmail()==null){
            $user->setEmail("null");
        }
        $userData = array(
            'ID_LIV_PERS'=> $user->getId(),
            'NUM_HARPEGE'=> $user->getNumHarpege(),
            'USR_PASSWORD' => $user->getPassword(),
            'USR_SALT' => $user->getSalt(),
            'NOM'=> $user->getNom(),
            'PRENOM'=> $user->getPrenom(),
            'EMAIL' => $user->getEmail(),
            'USR_ROLE' => $user->getRole(),
            'USR_NAME' => $user->getUsername()
            );

        if ($this->isExistingUserInDB($user)) {
            // The user has already been saved : update it
            $this->getDb()->update('LIVRET_PERSONNEL', $userData, array('ID_LIV_PERS' => $user->getId()));
        } else {
            // The user has never been saved : insert it
            $this->getDb()->insert('LIVRET_PERSONNEL', $userData);
            // Get the id of the newly created user and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $user->setId($id);
        }
    }
    
    public function isExistingUserInDB(User $user) {
        $req = "select * from LIVRET_PERSONNEL where ID_LIV_PERS = ".$user->getId();
        $result = $this->getDb()->executeQuery($req); 
        if($result->fetch() == null){
            return FALSE;
        }else{
            return TRUE;
        }
    }

    /**
     * Removes a user from the database.
     *
     * @param @param integer $id The user id.
     */
    public function delete($id) {
        // Delete the user
        $this->getDb()->delete('LIVRET_PERSONNEL', array('ID_LIV_PERS' => $id));
    }
    
        /**
     * Retrieve all personnel from the database.
     */
    public function getAllTeacher() {
        $sql = "select ID_PERS as ID_LIV_PERS, NUM_HARPEGE,NOM as USR_NAME,NOM as USR_PASSWORD,NOM as USR_SALT, NOM as USR_ROLE, NOM, PRENOM, EMAIL FROM PERSONNEL";
        $result = $this->getDb()->fetchAll($sql);
        // Convert query result to an array of domain objects
        $teachers = array();
        foreach ($result as $row) {
            $id = $row['ID_LIV_PERS']." - ".$row['NOM'];
            $teachers[$id] = $this->buildDomainObject($row);
        }
        return $teachers;
    }
    
        public function getEditTeacher($id) {
        $sql = "select ID_PERS as ID_LIV_PERS, NUM_HARPEGE,NOM as USR_NAME,NOM as USR_PASSWORD,NOM as USR_SALT, NOM as USR_ROLE, NOM, PRENOM, EMAIL FROM PERSONNEL where ID_PERS =".$id;
        $result = $this->getDb()->fetchAll($sql);
        // Convert query result to an array of domain objects
        $teachers = array();
        foreach ($result as $row) {
            $id = $row['ID_LIV_PERS']." - ".$row['NOM'];
            $teachers[$id] = $this->buildDomainObject($row);
        }
        return $teachers;
    }

    /**
     * Creates a User object based on a DB row.
     *
     * @param array $row The DB row containing User data.
     * @return \MicroCMS\Domain\User
     */
    protected function buildDomainObject(array $row) {
        $user = new User();
        $user->setId($row['ID_LIV_PERS']);
        $user->setUsername($row['USR_NAME']);
        $user->setPassword($row['USR_PASSWORD']);
        $user->setSalt($row['USR_SALT']);
        $user->setRole($row['USR_ROLE']);
        $user->setNom($row['NOM']);
        $user->setPrenom($row['PRENOM']);
        $user->setEmail($row['EMAIL']);
        $user->setNumHarpege($row['NUM_HARPEGE']);
        
        return $user;
    }
    
}