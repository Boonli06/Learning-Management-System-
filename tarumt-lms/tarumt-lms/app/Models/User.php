<?php

class User {
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $passwordHash;
    private $role;
    private $verified;
    private $avatar;
    private $createdAt;
    private $updatedAt;
    
    // User roles
    const ROLE_STUDENT = 'student';
    const ROLE_INSTRUCTOR = 'instructor';
    const ROLE_ADMIN = 'admin';
    
    public function __construct($data = []) {
        if ($data) {
            $this->hydrate($data);
        }
    }
    
    private function hydrate($data) {
        $this->id = $data['id'] ?? null;
        $this->firstName = $data['first_name'] ?? null;
        $this->lastName = $data['last_name'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->passwordHash = $data['password_hash'] ?? null;
        $this->role = $data['role'] ?? self::ROLE_STUDENT;
        $this->verified = (bool)($data['verified'] ?? false);
        $this->avatar = $data['avatar'] ?? null;
        $this->createdAt = $data['created_at'] ?? null;
        $this->updatedAt = $data['updated_at'] ?? null;
    }
    
    // Getters
    public function getId() { return $this->id; }
    public function getFirstName() { return $this->firstName; }
    public function getLastName() { return $this->lastName; }
    public function getFullName() { return trim($this->firstName . ' ' . $this->lastName); }
    public function getEmail() { return $this->email; }
    public function getRole() { return $this->role; }
    public function isVerified() { return $this->verified; }
    public function getAvatar() { return $this->avatar; }
    public function getCreatedAt() { return $this->createdAt; }
    public function getUpdatedAt() { return $this->updatedAt; }
    
    // Setters
    public function setFirstName($firstName) { $this->firstName = $firstName; }
    public function setLastName($lastName) { $this->lastName = $lastName; }
    public function setEmail($email) { $this->email = $email; }
    public function setRole($role) { 
        if (in_array($role, [self::ROLE_STUDENT, self::ROLE_INSTRUCTOR, self::ROLE_ADMIN])) {
            $this->role = $role;
        }
    }
    public function setVerified($verified) { $this->verified = (bool)$verified; }
    public function setAvatar($avatar) { $this->avatar = $avatar; }
    
    // Password methods
    public function setPassword($password) {
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }
    
    public function verifyPassword($password) {
        return password_verify($password, $this->passwordHash);
    }
    
    // Role checking methods
    public function isStudent() { return $this->role === self::ROLE_STUDENT; }
    public function isInstructor() { return $this->role === self::ROLE_INSTRUCTOR; }
    public function isAdmin() { return $this->role === self::ROLE_ADMIN; }
    
    // Avatar generation
    public function generateAvatar() {
        $name = urlencode($this->getFullName());
        $this->avatar = "https://ui-avatars.com/api/?name={$name}&background=000000&color=ffffff&size=200";
        return $this->avatar;
    }
    
    // Validation methods
    public function validate() {
        $errors = [];
        
        if (empty($this->firstName)) {
            $errors[] = 'First name is required';
        }
        
        if (empty($this->lastName)) {
            $errors[] = 'Last name is required';
        }
        
        if (empty($this->email)) {
            $errors[] = 'Email is required';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }
        
        if (empty($this->passwordHash)) {
            $errors[] = 'Password is required';
        }
        
        return $errors;
    }
    
    // Convert to array for JSON serialization
    public function toArray($includePassword = false) {
        $data = [
            'id' => $this->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'full_name' => $this->getFullName(),
            'email' => $this->email,
            'role' => $this->role,
            'verified' => $this->verified,
            'avatar' => $this->avatar,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt
        ];
        
        if ($includePassword) {
            $data['password_hash'] = $this->passwordHash;
        }
        
        return $data;
    }
    
    // Static methods for dummy data
    public static function getDummyUsers() {
        return [
            'student@tarumt.edu' => new self([
                'id' => 1,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'student@tarumt.edu',
                'password_hash' => password_hash('password', PASSWORD_DEFAULT),
                'role' => self::ROLE_STUDENT,
                'verified' => true,
                'avatar' => 'https://ui-avatars.com/api/?name=John+Doe&background=000000&color=ffffff',
                'created_at' => '2024-01-15 10:30:00',
                'updated_at' => '2024-01-15 10:30:00'
            ]),
            'instructor@tarumt.edu' => new self([
                'id' => 2,
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'instructor@tarumt.edu',
                'password_hash' => password_hash('password', PASSWORD_DEFAULT),
                'role' => self::ROLE_INSTRUCTOR,
                'verified' => true,
                'avatar' => 'https://ui-avatars.com/api/?name=Jane+Smith&background=000000&color=ffffff',
                'created_at' => '2024-01-10 09:15:00',
                'updated_at' => '2024-01-10 09:15:00'
            ]),
            'admin@tarumt.edu' => new self([
                'id' => 3,
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => 'admin@tarumt.edu',
                'password_hash' => password_hash('password', PASSWORD_DEFAULT),
                'role' => self::ROLE_ADMIN,
                'verified' => true,
                'avatar' => 'https://ui-avatars.com/api/?name=Admin+User&background=000000&color=ffffff',
                'created_at' => '2024-01-01 08:00:00',
                'updated_at' => '2024-01-01 08:00:00'
            ])
        ];
    }
    
    public static function findByEmail($email) {
        $users = self::getDummyUsers();
        return $users[$email] ?? null;
    }
    
    public static function authenticate($email, $password) {
        $user = self::findByEmail($email);
        if ($user && $user->verifyPassword($password)) {
            return $user;
        }
        return null;
    }
}