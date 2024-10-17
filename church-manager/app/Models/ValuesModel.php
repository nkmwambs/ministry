<?php

namespace App\Models;

use CodeIgniter\Model;

class ValuesModel extends Model
{
    protected $table            = 'customvalues';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','feature_id','record_id','customfield_id','value'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getFieldValuesForRecord($recordId, $tableName)
    {
        $fieldValues = $this->where('record_id', $recordId)
                            ->where('table_name', $tableName)
                            ->findAll();
                            
        $result = [];
        foreach ($fieldValues as $fieldValue) {
            $result[$fieldValue['customfield_id']] = $fieldValue['value'];
        }
        
        return $result;
    }

    public function saveCustomFieldValues($recordId, $tableName, $customFieldValues)
    {
        foreach ($customFieldValues as $fieldId => $value) {
            // Check if the field already exists
            $existing = $this->where('record_id', $recordId)
                             ->where('customfield_id', $fieldId)
                             ->where('table_name', $tableName)
                             ->first();

            if ($existing) {
                $update_data = ['value' => $value];
                // Update value
                $this->update($existing['id'], (object)$update_data);
            } else {
                $data = [
                    'record_id' => $recordId,
                    'customfield_id' => $fieldId,
                    'value' => $value,
                    'table_name' => $tableName
                ];
                // Insert new value
                $this->insert((object)$data);
            }
        }
    }
}
