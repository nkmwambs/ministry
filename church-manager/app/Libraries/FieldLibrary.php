<?php 

namespace App\Libraries;

class FieldLibrary implements \App\Interfaces\LibraryInterface {
    protected $customFieldModel;
    protected $customValueModel;

    public function __construct()
    {
        $this->customFieldModel = new \App\Models\FieldsModel();
        $this->customValueModel = new \App\Models\ValuesModel();
    }

    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['customfields.id','denomination_id','customfields.name','table_name','type','options','feature_id','field_order','visible','features.name as feature_name'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['customfields.id','denomination_id','customfields.name','table_name','type','options','feature_id','field_order','visible','features.name as feature_name'];
        return $fields;
    }

    /**
     * Get custom fields for a specific table (e.g., 'users', 'products', etc.).
     *
     * @param string $tableName
     * @return array
     */
    public function getCustomFieldsForTable(string $tableName): array
    {
        return $this->customFieldModel
            ->where('table_name', $tableName)
            ->findAll();
    }

    /**
     * Save custom field values for a specific record.
     *
     * @param int $recordId
     * @param string $tableName
     * @param array $customFieldValues
     * @return bool
     */
    public function saveCustomFieldValues(int $recordId, string $tableName, array $customFieldValues): bool
    {
        foreach ($customFieldValues as $fieldId => $value) {
            // Check if the custom field value already exists for this record
            $existing = $this->customValueModel
                ->where('record_id', $recordId)
                ->where('table_name', $tableName)
                ->where('field_id', $fieldId)
                ->first();

            if ($existing) {
                $update_data = [
                    'field_value' => $value,
                ];
                // Update existing custom field value
                $this->customValueModel->update($existing['id'], (object)$update_data);
            } else {
                $data = [
                    'record_id'   => $recordId,
                    'table_name'  => $tableName,
                    'field_id'    => $fieldId,
                    'field_value' => $value,
                ];
                // Insert new custom field value
                $this->customValueModel->insert((object)$data);
            }
        }

        return true;
    }

    /**
     * Get custom field values for a specific record.
     *
     * @param int $recordId
     * @param string $tableName
     * @return array
     */
    public function getCustomFieldValuesForRecord(int $recordId, string $tableName): array
    {
        $customFieldValues = $this->customValueModel
            ->where('record_id', $recordId)
            ->where('table_name', $tableName)
            ->findAll();

        // Format the result into an associative array [field_id => field_value]
        $formattedValues = [];
        foreach ($customFieldValues as $value) {
            $formattedValues[$value['field_id']] = $value['field_value'];
        }

        return $formattedValues;
    }

    /**
     * Delete all custom field values associated with a specific record.
     *
     * @param int $recordId
     * @param string $tableName
     * @return bool
     */
    public function deleteCustomFieldValues(int $recordId, string $tableName): bool
    {
        return $this->customValueModel
            ->where('record_id', $recordId)
            ->where('table_name', $tableName)
            ->delete();
    }

    
    function listExtraData(&$page_data) {
        
        $parent_id = 0;
        $feature_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['feature_id'] = hash_id($feature_id,'encode');
    }

    function addExtraData(&$page_data) {
        $parent_id = 0;
        $feature_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $featuresModel = new \App\Models\FeaturesModel();
        $features = $featuresModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['features'] = $features;

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['feature_id'] = hash_id($feature_id, 'encode');
    }

    function editExtraData (&$page_data) {
        $numeric_denomination_id = 0;
        $numeric_feature_id = 0;

        if (session()->get('user_denomination_id')) {
            $numeric_denomination_id = session()->get('user_denomination_id');
        }
        
        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $featuresModel = new \App\Models\FeaturesModel();
        $features = $featuresModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['features'] = $features;
        
        $page_data['numeric_denomination_id'] = $numeric_denomination_id;
        $page_data['numeric_feature_id'] = $numeric_feature_id;
    }
}