
<?php 

$this->extend('layouts/add');

$tableName = "members";
$featureName = "member";

$this->section('pageTitle');
echo lang("$featureName.add_$featureName");
$this->endSection();


$this->section('standardPaneContent');
echo $this->include("admin/$featureName/add_segments/add_basic");
$this->endSection();

$this->section('additionalPaneContent');
echo $this->include("admin/$featureName/add_segments/add_additional");
$this->endSection();

$this->section('style');
echo $this->include("admin/$featureName/add_segments/add_style");
$this->endSection();

$this->section('javascript');
echo $this->include("admin/$featureName/add_segments/add_javascript");
$this->endSection();

