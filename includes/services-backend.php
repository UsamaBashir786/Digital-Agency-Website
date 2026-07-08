<?php
// includes/services-backend.php

class ServicesBackend {
    private $db;
    private $table = 'services';
    
    public function __construct($db) {
        $this->db = $db;
        
        // Check if connection is valid
        if (!$this->db) {
            die("Database connection failed in ServicesBackend constructor");
        }
    }
    
    /**
     * Get all active services
     */
    public function getAllServices($category = null, $search = null) {
        $sql = "SELECT * FROM {$this->table} WHERE is_active = 1";
        $params = [];
        $types = "";
        
        if ($category && $category !== 'all') {
            $sql .= " AND category = ?";
            $params[] = $category;
            $types .= "s";
        }
        
        if ($search && !empty($search)) {
            $sql .= " AND (title LIKE ? OR description LIKE ? OR service_id LIKE ?)";
            $searchTerm = "%{$search}%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $types .= "sss";
        }
        
        $sql .= " ORDER BY sort_order ASC, id ASC";
        
        $stmt = $this->db->prepare($sql);
        
        if (!$stmt) {
            error_log("SQL Prepare Error: " . $this->db->error);
            return [];
        }
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        $services = [];
        while ($row = $result->fetch_assoc()) {
            $services[] = $row;
        }
        
        return $services;
    }
    
    /**
     * Get single service by ID
     */
    public function getServiceById($serviceId) {
        $sql = "SELECT * FROM {$this->table} WHERE service_id = ? AND is_active = 1";
        $stmt = $this->db->prepare($sql);
        
        if (!$stmt) {
            error_log("SQL Prepare Error: " . $this->db->error);
            return null;
        }
        
        $stmt->bind_param("s", $serviceId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    
    /**
     * Get service statistics
     */
    public function getServiceStats() {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN category = 'seo' THEN 1 ELSE 0 END) as seo_count,
                    SUM(CASE WHEN category = 'development' THEN 1 ELSE 0 END) as dev_count,
                    SUM(CASE WHEN category = 'marketing' THEN 1 ELSE 0 END) as marketing_count
                FROM {$this->table} 
                WHERE is_active = 1";
        
        $result = $this->db->query($sql);
        
        if (!$result) {
            error_log("Query Error: " . $this->db->error);
            return ['total' => 0, 'seo_count' => 0, 'dev_count' => 0, 'marketing_count' => 0];
        }
        
        return $result->fetch_assoc();
    }
    
    /**
     * Get services by category
     */
    public function getServicesByCategory($category) {
        return $this->getAllServices($category);
    }
    
    /**
     * Search services
     */
    public function searchServices($query) {
        return $this->getAllServices(null, $query);
    }
    
    /**
     * Add a new service
     */
    public function addService($data) {
        $sql = "INSERT INTO {$this->table} (
                    service_id, title, description, icon, category, 
                    projects, satisfaction, link, meta_title, meta_description, 
                    sort_order, is_active
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        
        if (!$stmt) {
            error_log("SQL Prepare Error: " . $this->db->error);
            return false;
        }
        
        $stmt->bind_param(
            "ssssssssssii",
            $data['service_id'],
            $data['title'],
            $data['description'],
            $data['icon'],
            $data['category'],
            $data['projects'],
            $data['satisfaction'],
            $data['link'],
            $data['meta_title'],
            $data['meta_description'],
            $data['sort_order'],
            $data['is_active']
        );
        
        return $stmt->execute();
    }
    
    /**
     * Update a service
     */
    public function updateService($serviceId, $data) {
        $sql = "UPDATE {$this->table} SET 
                    title = ?,
                    description = ?,
                    icon = ?,
                    category = ?,
                    projects = ?,
                    satisfaction = ?,
                    link = ?,
                    meta_title = ?,
                    meta_description = ?,
                    sort_order = ?,
                    is_active = ?
                WHERE service_id = ?";
        
        $stmt = $this->db->prepare($sql);
        
        if (!$stmt) {
            error_log("SQL Prepare Error: " . $this->db->error);
            return false;
        }
        
        $stmt->bind_param(
            "sssssssssiii",
            $data['title'],
            $data['description'],
            $data['icon'],
            $data['category'],
            $data['projects'],
            $data['satisfaction'],
            $data['link'],
            $data['meta_title'],
            $data['meta_description'],
            $data['sort_order'],
            $data['is_active'],
            $serviceId
        );
        
        return $stmt->execute();
    }
    
    /**
     * Delete a service (soft delete)
     */
    public function deleteService($serviceId) {
        $sql = "UPDATE {$this->table} SET is_active = 0 WHERE service_id = ?";
        $stmt = $this->db->prepare($sql);
        
        if (!$stmt) {
            error_log("SQL Prepare Error: " . $this->db->error);
            return false;
        }
        
        $stmt->bind_param("s", $serviceId);
        return $stmt->execute();
    }
    
    /**
     * Get featured services
     */
    public function getFeaturedServices($limit = 6) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE is_active = 1 
                ORDER BY sort_order ASC, id ASC 
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        
        if (!$stmt) {
            error_log("SQL Prepare Error: " . $this->db->error);
            return [];
        }
        
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $services = [];
        while ($row = $result->fetch_assoc()) {
            $services[] = $row;
        }
        
        return $services;
    }
}
?>