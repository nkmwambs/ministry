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
        $fields = ['customfields.id','field_name','field_code','helptip','denomination_id','table_name','type','options','feature_id','field_order','visible','features.name as feature_name'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['customfields.id','field_name','field_code','helptip','denomination_id','table_name','type','options','feature_id','field_order','visible','features.name as feature_name'];
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
    public function saveCustomFieldValues(int $recordId, string $tableName, ?array $customFieldValues): bool
    {
        $featureModel = new \App\Models\FeaturesModel();
        $feature = $featureModel->where('name', singular($tableName))->first();

        $featureId = $feature['id'];

        if($customFieldValues && sizeOf($customFieldValues) > 0){
            foreach ($customFieldValues as $fieldId => $value) {
                // Check if the custom field value already exists for this record
                $existing = $this->customValueModel
                    ->where('record_id', $recordId)
                    ->where('feature_id', $featureId)
                    ->where('customfield_id', $fieldId)
                    ->first();
    
                if ($existing) {
                    $update_data = [
                        'value' => $value,                    ];
                    // Update existing custom field value
                    $this->customValueModel->update($existing['id'], (object)$update_data);
                } else {
                    $data = [
                        'record_id'   => $recordId,
                        'feature_id'  => $featureId,
                        'customfield_id'    => $fieldId,
                        'value' => $value // json_encode($value),
                    ];
                    // Insert new custom field value
                    $this->customValueModel->insert((object)$data);
                }
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
            ->where('features.name', singular($tableName))
            ->join('customfields','customfields.id=customvalues.customfield_id')
            ->join('features','features.id=customfields.feature_id')
            ->findAll();

        // Format the result into an associative array [field_id => field_value]
        $formattedValues = [];
        foreach ($customFieldValues as $value) {
            $formattedValues[$value['customfield_id']] = $value['value'];
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

    function getFieldUIElementProperties(int $fieldTypeId, object $fieldModel, array $report): array|bool{
        $field = $fieldModel->where('visible', 'yes')->find($fieldTypeId);
        if (!$field) {
            return false;
        }
        
        extract($field);

        $value = match(true){
            $query_builder != NULL => $this->computeFieldValue($query_builder, $report),
            $code_builder != NULL => $this->computeFieldValueByCodeBuilder($code_builder, $report),
            default => NULL,
        };

        $fieldObj = [
                'type' => $type,
                'field_code' => $field_code,
                'label' => $field_name,
                'helptip' => $helptip,
                'value' => $value, // $query_builder != NULL ? $this->computeFieldValue($query_builder, $report): '',
                'visible' => $visible,
                'class' => $field_code,
                'attributes' => []
        ];

        return $fieldObj;
    }

    function computeFieldValueByCodeBuilder($code_builder, $report){
        $db = \Config\Database::connect();

        $assemblyLibrary = new AssemblyLibrary();
        $assembly_id = $report['assembly_id'];
        $denomination_id = $assemblyLibrary->getAssemblyDenominationIdByAssemblyId($assembly_id);
        $report_period = $report['report_period'];
        $in_month = $report['report_period'];

        // Extract column labels inside `::`
        preg_match_all('/:([a-zA-Z_]+):/', $code_builder, $matches);
        // Get the column labels (second group of matches)
        $columnLabels = $matches[1];

        // Compacting columns to preset values
        $compact = [];
        foreach ($columnLabels as $key) {
            if(isset($$key)){
                $compact[$key] = $$key; // Use variable variables
            }
        }

        $query = $db->query($code_builder, $compact)->getRow();
        
        if($query){
            return $query->result;
        } else {
            return 0;
        }
    }

    function computeFieldValue(string $query_builder, array $report) {
        
        // [{"table": "members", "select": "count", "conditions": [{"key": "assembly_id", "operator": "equals"}]}]
        // [{"table": "members", "select": "count", "conditions": [{"key": "assembly_id", "operator": "equals"}, {"key": "gender", "value": "female", "operator": "equals"}]}]
        // [{"table": "members", "select": "count", "conditions": [{"key": "assembly_id", "operator": "equals"}, {"key": "saved_date", "operator": "in_month"}]}]
        // [{"table": "members", "select": "count", "conditions": [{"key": "assembly_id", "operator": "equals"}, {"key": "c__sanctified_date", "operator": "in_month"}]}]
        // [{"table": "members","join": [{"table": "designations","relation_id": "id","relation_order": 1,"relation_table":{"table": "members","relation_id": "designation_id"}},{"table": "departments","relation_id": "id","relation_order": 2,"relation_table": {"table": "designations","relation_id": "department_id"}}],"select": "count","conditions": [{"key": "assembly_id","operator": "equals"},{"key": "department_code","value": "youth_ministry","operator": "equals"}]}]
        
        $query_obj = json_decode($query_builder);

        $value = '';
        
        // Use the commented JSON above to create a CodeIgniter 4 Query 
        if(count($query_obj)){
            
            extract($report); // assembly_id, reports_type_id, report_period

            $query_obj_items = (array)$query_obj[0];
            extract($query_obj_items);

            $featureModel = new \App\Models\FeaturesModel();
            $feature = $featureModel->where('name', singular($table))->first();
            $feature_id = $feature['id'];

            $modelName = ucfirst($table).'Model';
            $model = new ("\\App\Models\\$modelName")();
            $queryResult = $model;

            // Aggregation query part
            if($select == 'count'){
                $queryResult->select('count(*)');
            }elseif($select == 'sum'){
                // log_message('error', json_encode($sum_field));
                $queryResult->selectSum($sum_field->field);
            }

            // Join query part 
            if(isset($join) && count($join)){
                $cnt = 1;
                foreach($join as $joinItem){
                    extract((array)$joinItem);
                    
                    if($cnt == $relation_order){
                        $relation_table_name = $relation_table->table;
                        $relation_table_id = $relation_table->relation_id;
    
                        $queryResult->join($table, "$table.$relation_id=$relation_table_name.$relation_table_id");
                    }
                    
                    $cnt++;
                }
            }
            
            // Condition query part
            if(count($conditions)){
                foreach($conditions as $condition){
                    if($condition->operator == 'equals'){
                        if($condition->key == 'assembly_id'){
                            $queryResult->where($condition->key, $assembly_id);
                        }elseif(strpos($condition->key, 'c__') !== false){

                            $queryResult->join('customvalues', 'customvalues.record_id = members.id', 'left');
                            $queryResult->join('customfields','customfields.id=customvalues.customfield_id');
                            $queryResult->where('customvalues.feature_id', $feature_id); 
                            
                            $field_key = substr($condition->key, 3);
                            $queryResult->where('field_code', $field_key);
                            $queryResult->where('value', $condition->value);
                        }else{
                            $queryResult->where($condition->key, $condition->value);
                        }

                    }

                    if($condition->operator == 'in_month'){
                        if(strpos($condition->key, 'c__') !== false){

                            $queryResult->join('customvalues', 'customvalues.record_id = members.id', 'left');
                            $queryResult->join('customfields','customfields.id=customvalues.customfield_id');
                            $queryResult->where('customvalues.feature_id', $feature_id); 
                            
                            $field_key = substr($condition->key, 3);
                            $queryResult->where('customfields.field_code', $field_key);
                            $queryResult->where("customvalues.value >=", date('Y-m-01',strtotime($report_period)))
                            ->where("customvalues.value <=", date('Y-m-t',strtotime($report_period)));
                        }else{
                            $queryResult->where("$condition->key >=", date('Y-m-01',strtotime($report_period)))
                            ->where("$condition->key <=", date('Y-m-t',strtotime($report_period)));
                        }
                        
                    }

                    if($condition->operator == 'IS NULL' || $condition->operator == 'IS NOT NULL'){
                        if(strpos($condition->key, 'c__') !== false){
                            $queryResult->join('customvalues', 'customvalues.record_id = members.id', 'left');
                            $queryResult->join('customfields','customfields.id=customvalues.customfield_id');
                            $queryResult->where('customvalues.feature_id', $feature_id); 
                            
                            $field_key = substr($condition->key, 3);
                            $queryResult->where('field_code', $field_key);
                            $queryResult->where("value $condition->operator", NULL);
                        }else{
                            $queryResult->where("$condition->key $condition->operator", NULL);
                        }
                    }
                }
            }

            $result = '';

            if($select == 'sum'){
                $result = $queryResult->first()[$sum_field->field]; 
                if(array_key_exists('compute',(array)$sum_field)){
                    if(array_key_exists('percent', (array)$sum_field->compute)){
                        $result = $result * $sum_field->compute->percent;
                    }
                }
            }else{
                $result = $queryResult->countAllResults();
            }

            $value = $result;
        }
        

        return $value; // Placeholder for actual field value computation
    }

    function getFieldInfoById($customFieldId){
        $fieldsModel = new \App\Models\FieldsModel();
        $field = $fieldsModel->where('id', $customFieldId)->first();
        return $field;
    }
}