<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\Auth\User\AccountController;
use App\Http\Controllers\Backend\Auth\User\ProfileController;
use \App\Http\Controllers\Backend\Auth\User\UpdatePasswordController;

/*
* All route names are prefixed with 'admin.'.
*/

//===== General Routes =====// 
Route::redirect('/', '/user/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('login-user-designation-ajax/{id}', 'DashboardController@loginUserDesignation');
Route::get('login-user-tabs-ajax/{id}', 'DashboardController@loginUsertabs');
Route::get('crtDetails-ajax/{id}', 'DashboardController@crtDetails');

Route::group(['middleware' => 'role:administrator'], function () {

//===== Teachers Routes =====//
Route::resource('teachers', 'Admin\TeachersController');
Route::get('get-teachers-data', ['uses' => 'Admin\TeachersController@getData', 'as' => 'teachers.get_data']);
Route::post('teachers_mass_destroy', ['uses' => 'Admin\TeachersController@massDestroy', 'as' => 'teachers.mass_destroy']);
Route::post('teachers_restore/{id}', ['uses' => 'Admin\TeachersController@restore', 'as' => 'teachers.restore']);
Route::delete('teachers_perma_del/{id}', ['uses' => 'Admin\TeachersController@perma_del', 'as' => 'teachers.perma_del']);

//---------Ministry Routes------//

Route::resource('ministry', 'Admin\MinistryController');
Route::get('get-ministry-data', ['uses' => 'Admin\MinistryController@getData', 'as' => 'ministry.get_data']);
Route::get('ministry/unpublish/{id}', ['uses' => 'Admin\MinistryController@unpublish', 'as' => 'ministry.unpublish']);
Route::get('ministry/publish/{id}', ['uses' => 'Admin\MinistryController@publish', 'as' => 'ministry.publish']);

// ---------Year-----------------------//
Route::resource('year', 'Admin\YearController');
Route::get('get-year-data', ['uses' => 'Admin\YearController@getData', 'as' => 'year.get_data']);
Route::get('year/department-ajax/{id}', ['uses' => 'Admin\YearController@departmentFilter', 'as' => 'years.department-ajax']);
Route::get('year/office-ajax/{id}', ['uses' => 'Admin\YearController@officeFilter', 'as' => 'years.office-ajax']);

Route::get('year/unpublish/{id}', ['uses' => 'Admin\YearController@unpublish', 'as' => 'year.unpublish']);
Route::get('year/publish/{id}', ['uses' => 'Admin\YearController@publish', 'as' => 'year.publish']); 

// ---------Office Order-----------------------//
Route::resource('officeorder', 'Admin\OfficeorderController');
Route::get('get-officeorder-data', ['uses' => 'Admin\OfficeorderController@getData', 'as' => 'officeorder.get_data']);
// Route::get('officeorder/office-ajax/{id}', ['uses' => 'Admin\OfficeorderController@officeFilter', 'as' => 'faculty.office-ajax']);
Route::get('officeorder/signing-ajax/{id}', ['uses' => 'Admin\OfficeorderController@signFilter', 'as' => 'officeorder.office-ajax']);
Route::get('officeorder/empcode-ajax/{id}', ['uses' => 'Admin\OfficeorderController@empcodeFilter', 'as' => 'officeorder.office-ajax']);
Route::get('officeorder/showRemove-ajax/{id}', ['uses' => 'Admin\OfficeorderController@showRemoveFilter', 'as' => 'officeorder.showRemove-ajax']);
Route::get('officeorder/removeNomination-ajax/{id}', ['uses' => 'Admin\OfficeorderController@removeNominationFilter', 'as' => 'officeorder.removeNomination-ajax']);

Route::get('officeorder/trainingid_ajax/{id}', ['uses' => 'Admin\OfficeorderController@trainingFilter', 'as' => 'officeorder.trainingid_ajax']);
Route::get('officeorder/index', ['uses' => 'Admin\OfficeorderController@index', 'as' => 'officeorder.index']);

Route::get('officeorder/training_office_order_ajax/{id}/{departmentid}', ['uses' => 'Admin\OfficeorderController@training_office_order_ajax', 'as' => 'officeorder.training_office_order_ajax']);

Route::get('officeorder/update_ajax/{id}', ['uses' => 'Admin\OfficeorderController@update_ajax', 'as' => 'officeorder.update_ajax']);

Route::get('officeorder/partialadd_ajax/{id}', ['uses' => 'Admin\OfficeorderController@partialadd_ajax', 'as' => 'officeorder.partialadd_ajax']);

Route::get('officeorder/partialsave/{deptid}/{trainingid}/{fileno}/{id}', ['uses' => 'Admin\OfficeorderController@partialsave', 'as' => 'officeorder.partialsave']);

// ---------Agenda-----------------------// 
Route::resource('agenda', 'Admin\AgendaController');
Route::get('get-agenda-data', ['uses' => 'Admin\AgendaController@getData', 'as' => 'agenda.get_data']);
Route::get('agenda/speaker-ajax/{id}', ['uses' => 'Admin\AgendaController@speakerFilter', 'as' => 'agenda.speaker-ajax']);

// ---------PDF-----------------------// 
Route::resource('agendaPDF', 'Admin\PdfController');

// ---------Office Order Content Management-----------------------// 
Route::resource('officeorder_content_management', 'Admin\OoContentManagementController');
Route::get('get-officeorder_content_management-data', ['uses' => 'Admin\OoContentManagementController@getData', 'as' => 'officeorder_content_management.get_data']);

// ---------Documents-----------------------// 
Route::resource('documents', 'Admin\DocumentController');
Route::get('get-documents-data', ['uses' => 'Admin\DocumentController@getData', 'as' => 'documents.get_data']);

// ---------Faculty-----------------------// 
Route::resource('faculty', 'Admin\FacultyController');
Route::get('get-faculty-data', ['uses' => 'Admin\FacultyController@getData', 'as' => 'faculty.get_data']);
Route::get('faculty/office-ajax/{id}', ['uses' => 'Admin\FacultyController@officeFilter', 'as' => 'faculty.office-ajax']);
Route::get('faculty/selectinstitute/{id}', ['uses' => 'Admin\FacultyController@selectinstitute', 'as' => 'faculty.selectinstitute']);
Route::get('faculty/unpublish/{id}', ['uses' => 'Admin\FacultyController@unpublish', 'as' => 'faculty.unpublish']);
Route::get('faculty/publish/{id}', ['uses' => 'Admin\FacultyController@publish', 'as' => 'faculty.publish']); 

// ---------Subject-----------------------// 
Route::resource('subject', 'Admin\SubjectController');
Route::get('get-subject-data', ['uses' => 'Admin\SubjectController@getData', 'as' => 'subject.get_data']);
Route::get('subject/office-ajax/{id}', ['uses' => 'Admin\SubjectController@officeFilter', 'as' => 'subject.office-ajax']);
Route::get('subject/selectinstitute/{id}', ['uses' => 'Admin\SubjectController@selectinstitute', 'as' => 'subject.selectinstitute']);
Route::get('subject/unpublish/{id}', ['uses' => 'Admin\SubjectController@unpublish', 'as' => 'subject.unpublish']);
Route::get('subject/publish/{id}', ['uses' => 'Admin\SubjectController@publish', 'as' => 'subject.publish']); 

 // ---------Department Role-----------------------//
 Route::resource('department_role', 'Admin\DepartmentRoleController');
 Route::get('get-department_role-data', ['uses' => 'Admin\DepartmentRoleController@getData', 'as' => 'department_role.get_data']);
 Route::get('department_role/office-ajax/{id}', ['uses' => 'Admin\DepartmentRoleController@officeFilter', 'as' => 'department_role.office-ajax']);
 Route::get('department_role/parent-department-ajax/{id}', ['uses' => 'Admin\DepartmentRoleController@parentDepartmentFilter', 'as' => 'department_role.parent-department-ajax']);
 Route::get('department_role/unpublish/{id}', ['uses' => 'Admin\DepartmentRoleController@unpublish', 'as' => 'department_role.unpublish']);
Route::get('department_role/publish/{id}', ['uses' => 'Admin\DepartmentRoleController@publish', 'as' => 'department_role.publish']);

// ---------Organization Departments-----------------------//
 Route::resource('organization_departments', 'Admin\OrganizationDepartmentsController');
 Route::get('get-organization_departments-data', ['uses' => 'Admin\OrganizationDepartmentsController@getData', 'as' => 'organization_departments.get_data']);
 Route::get('organization_departments/office-ajax/{id}', ['uses' => 'Admin\OrganizationDepartmentsController@officeFilter', 'as' => 'organization_departments.office-ajax']);
 Route::get('organization_departments/unpublish/{id}', ['uses' => 'Admin\OrganizationDepartmentsController@unpublish', 'as' => 'organization_departments.unpublish']);
 Route::get('organization_departments/publish/{id}', ['uses' => 'Admin\OrganizationDepartmentsController@publish', 'as' => 'organization_departments.publish']);
 
// ---------Training types-----------------------//
Route::resource('training_types', 'Admin\Training_typesController');
Route::get('get-training_types-data', ['uses' => 'Admin\Training_typesController@getData', 'as' => 'training_types.get_data']);
Route::get('training_types/publish/{id}', ['uses' => 'Admin\Training_typesController@publish', 'as' => 'training_types.publish']);
Route::get('training_types/unpublish/{id}', ['uses' => 'Admin\Training_typesController@unpublish', 'as' => 'training_types.unpublish']);


// ---------Track-----------------------//
Route::resource('track', 'Admin\TrackController');
Route::get('get-track-data', ['uses' => 'Admin\TrackController@getData', 'as' => 'track.get_data']);
Route::get('track/department-ajax/{id}', ['uses' => 'Admin\TrackController@departmentFilter', 'as' => 'tracks.department-ajax']);
Route::get('track/office-ajax/{id}', ['uses' => 'Admin\TrackController@officeFilter', 'as' => 'track.office-ajax']);

Route::get('track/unpublish/{id}', ['uses' => 'Admin\TrackController@unpublish', 'as' => 'track.unpublish']);
Route::get('track/publish/{id}', ['uses' => 'Admin\TrackController@publish', 'as' => 'track.publish']); 


// ---------Veunue-----------------------//
Route::resource('venue', 'Admin\VenueController');
Route::get('get-venue-data', ['uses' => 'Admin\VenueController@getData', 'as' => 'venue.get_data']);
Route::get('get/department-ajax/{id}', ['uses' => 'Admin\VenueController@departmentFilter', 'as' => 'venues.department-ajax']);
Route::get('venue/statecity-ajax/{id}', ['uses' => 'Admin\VenueController@statecityFilter', 'as' => 'venue.statecity-ajax']);
Route::get('venue/office-ajax/{id}', ['uses' => 'Admin\VenueController@officeFilter', 'as' => 'venue.office-ajax']);

Route::get('venue/unpublish/{id}', ['uses' => 'Admin\VenueController@unpublish', 'as' => 'venue.unpublish']);
Route::get('venue/publish/{id}', ['uses' => 'Admin\VenueController@publish', 'as' => 'venue.publish']); 


// ---------Veunue-----------------------//
Route::resource('nominations', 'Admin\NominationsController');
Route::get('nominations/training-ajax/{id}', ['uses' => 'Admin\NominationsController@trainingFilter', 'as' => 'nominations.training-ajax']);

// ---------Training-Type-----------------------//

//Route::resource('training-types', 'Admin\TrainingTypeController');
//Route::get('get-institutes-industries-data', ['uses' => 'Admin\TrainingTypeController@getData', 'as' => 'training-types.get_data']);


//Route::resource('trainingtype', 'Admin\TrainingtypeController');
//Route::get('get-trainingtype-data', ['uses' => 'Admin\TrainingtypeController@getData', 'as' => 'trainingtypes.get_data']);


/*Route::get('get/department-ajax/{id}', ['uses' => 'Admin\TrainingtypeController@departmentFilter', 'as' => 'trainingtypes.department-ajax']);
Route::get('trainingtype/unpublish/{id}', ['uses' => 'Admin\TrainingtypeController@unpublish', 'as' => 'trainingtypes.unpublish']);
Route::get('trainingtype/publish/{id}', ['uses' => 'Admin\TrainingtypeController@publish', 'as' => 'trainingtypes.publish']); */



// ---------Section-----------------------//
Route::resource('section', 'Admin\SectionofficerController');
Route::get('get-section-data', ['uses' => 'Admin\SectionofficerController@getData', 'as' => 'section.get_data']);
Route::get('get/section-ajax/{id}', ['uses' => 'Admin\SectionofficerController@departmentFilter', 'as' => 'sections.section-ajax']);
Route::get('venue/section-ajax/{id}', ['uses' => 'Admin\SectionofficerController@officeFilter', 'as' => 'section.office-ajax']);
Route::get('section/publish/{id}', ['uses' => 'Admin\SectionofficerController@publish', 'as' => 'section.publish']);
Route::get('section/unpublish/{id}', ['uses' => 'Admin\SectionofficerController@unpublish', 'as' => 'section.unpublish']);


// ---------Signing-----------------------//
Route::resource('signing', 'Admin\SigningController');
Route::get('get-signing-data', ['uses' => 'Admin\SigningController@getData', 'as' => 'signing.get_data']);
Route::get('get/section-ajax/{id}', ['uses' => 'Admin\SigningController@departmentFilter', 'as' => 'signings.section-ajax']);
Route::get('signing/section-ajax/{id}', ['uses' => 'Admin\SigningController@officeFilter', 'as' => 'signing.office-ajax']);
Route::get('signing/publish/{id}', ['uses' => 'Admin\SigningController@publish', 'as' => 'signing.publish']);
Route::get('signing/unpublish/{id}', ['uses' => 'Admin\SigningController@unpublish', 'as' => 'signing.unpublish']);
Route::get('signing/department-ajax/{id}', ['uses' => 'Admin\SigningController@departmentFilter', 'as' => 'signing.department-ajax']);  
Route::get('signing/office-ajax/{id}', ['uses' => 'Admin\SigningController@officeFilter', 'as' => 'signing.office-ajax']);


// ---------Crt-----------------------//
//Route::resource('crt', 'Admin\CrtController');
//Route::get('get-crt-data', ['uses' => 'Admin\CrtController@getData', 'as' => 'crt.get_data']);
//Route::get('get/crt-ajax/{id}', ['uses' => 'Admin\CrtController@departmentFilter', 'as' => 'crts.section-ajax']);
//Route::get('crt/section-ajax/{id}', ['uses' => 'Admin\CrtController@officeFilter', 'as' => 'crt.office-ajax']);
//Route::get('crt/office-ajax/{id}', ['uses' => 'Admin\CrtController@officeFilter', 'as' => 'crt.office-ajax']);
//Route::get('crt/category-ajax/{id}', ['uses' => 'Admin\CrtController@categoryFilter', 'as' => 'crt.category-ajax']);
//Route::get('crt/city-ajax/{id}', ['uses' => 'Admin\CrtController@cityFilter', 'as' => 'crt.city-ajax']);
//Route::get('crt/training_for-ajax/{id}', ['uses' => 'Admin\CrtController@trainingForFilter', 'as' => 'crt.training_for-ajax']);
//Route::get('crt/faculty-ajax/{id}', ['uses' => 'Admin\CrtController@facultyFilter', 'as' => 'crt.faculty-ajax']); 
//Route::get('crt/unpublish/{id}', ['uses' => 'Admin\CrtController@unpublish', 'as' => 'crt.unpublish']); 
//Route::get('crt/publish/{id}', ['uses' => 'Admin\CrtController@publish', 'as' => 'crt.publish']);

//------------Departments-----//
Route::resource('departments', 'Admin\DepartmentsController');
Route::get('get-departments-data', ['uses' => 'Admin\DepartmentsController@getData', 'as' => 'departments.get_data']);
Route::get('departments/unpublish/{id}', ['uses' => 'Admin\DepartmentsController@unpublish', 'as' => 'departments.unpublish']);
Route::get('departments/publish/{id}', ['uses' => 'Admin\DepartmentsController@publish', 'as' => 'departments.publish']);

//------------locations-----//

Route::resource('locations', 'Admin\LocationsController');
Route::get('get-locations-data', ['uses' => 'Admin\LocationsController@getData', 'as' => 'locations.get_data']);
Route::get('locations/department-ajax/{id}', ['uses' => 'Admin\LocationsController@departmentFilter', 'as' => 'locations.department-ajax']);
Route::get('locations/cities-ajax/{id}', ['uses' => 'Admin\LocationsController@citiesFilter', 'as' => 'locations.cities-ajax']);

Route::get('locations/unpublish/{id}', ['uses' => 'Admin\LocationsController@unpublish', 'as' => 'locations.unpublish']);
Route::get('locations/publish/{id}', ['uses' => 'Admin\LocationsController@publish', 'as' => 'locations.publish']);


//------------States-----//

Route::resource('states', 'Admin\StatesController');
Route::get('get-states-data', ['uses' => 'Admin\StatesController@getData', 'as' => 'states.get_data']);

Route::get('states/unpublish/{id}', ['uses' => 'Admin\StatesController@unpublish', 'as' => 'states.unpublish']);
Route::get('states/publish/{id}', ['uses' => 'Admin\StatesController@publish', 'as' => 'states.publish']);

//------------Cities-----//

Route::resource('cities', 'Admin\CitiesController');
Route::get('get-cities-data', ['uses' => 'Admin\CitiesController@getData', 'as' => 'cities.get_data']);

Route::get('cities/unpublish/{id}', ['uses' => 'Admin\CitiesController@unpublish', 'as' => 'cities.unpublish']);
Route::get('cities/publish/{id}', ['uses' => 'Admin\CitiesController@publish', 'as' => 'cities.publish']);


//------------SubCategories-----// 

Route::resource('subcategories', 'Admin\SubCategoriesController');
Route::get('get-subcategories-data', ['uses' => 'Admin\SubCategoriesController@getData', 'as' => 'subcategories.get_data']);
 

Route::get('subcategories/index/{id}', ['uses' => 'Admin\SubCategoriesController@index', 'as' => 'subcategories.index']);

//Route::get('subcategories/create1/{id}', ['uses' => 'Admin\SubCategoriesController@create1', 'as' => 'subcategories.create1']);

Route::get('subcategories/unpublish/{id}', ['uses' => 'Admin\SubCategoriesController@unpublish', 'as' => 'subcategories.unpublish']);
Route::get('subcategories/publish/{id}', ['uses' => 'Admin\SubCategoriesController@publish', 'as' => 'subcategories.publish']);


//------------newsflash-----//

Route::resource('newsflash', 'Admin\NewsFlashController');
Route::get('get-newsflash-data', ['uses' => 'Admin\NewsFlashController@getData', 'as' => 'newsflash.get_data']);

Route::get('newsflash/unpublish/{id}', ['uses' => 'Admin\NewsFlashController@unpublish', 'as' => 'newsflash.unpublish']);
Route::get('newsflash/publish/{id}', ['uses' => 'Admin\NewsFlashController@publish', 'as' => 'newsflash.publish']);

});

// ---------Crt-----------------------//
Route::resource('crt', 'Admin\CrtController');
Route::get('get-crt-data', ['uses' => 'Admin\CrtController@getData', 'as' => 'crt.get_data']);
Route::get('get/crt-ajax/{id}', ['uses' => 'Admin\CrtController@departmentFilter', 'as' => 'crts.section-ajax']);
Route::get('crt/section-ajax/{id}', ['uses' => 'Admin\CrtController@officeFilter', 'as' => 'crt.office-ajax']);
Route::get('crt/office-ajax/{id}', ['uses' => 'Admin\CrtController@officeFilter', 'as' => 'crt.office-ajax']);
Route::get('crt/category-ajax/{id}', ['uses' => 'Admin\CrtController@categoryFilter', 'as' => 'crt.category-ajax']);
Route::get('crt/city-ajax/{id}', ['uses' => 'Admin\CrtController@cityFilter', 'as' => 'crt.city-ajax']);
Route::get('crt/training_for-ajax/{id}', ['uses' => 'Admin\CrtController@trainingForFilter', 'as' => 'crt.training_for-ajax']);
Route::get('crt/faculty-ajax/{id}', ['uses' => 'Admin\CrtController@facultyFilter', 'as' => 'crt.faculty-ajax']); 
Route::get('crt/unpublish/{id}', ['uses' => 'Admin\CrtController@unpublish', 'as' => 'crt.unpublish']); 
Route::get('crt/publish/{id}', ['uses' => 'Admin\CrtController@publish', 'as' => 'crt.publish']);

//------------designations-----//

Route::resource('designations', 'Admin\DesignationsController');
Route::get('get-designations-data', ['uses' => 'Admin\DesignationsController@getData', 'as' => 'designations.get_data']);
Route::get('designations/department-ajax/{id}', ['uses' => 'Admin\DesignationsController@departmentFilter', 'as' => 'designations.department-ajax']);
Route::get('designations/office-ajax/{id}', ['uses' => 'Admin\DesignationsController@officeFilter', 'as' => 'designations.office-ajax']);

Route::get('designations/unpublish/{id}', ['uses' => 'Admin\DesignationsController@unpublish', 'as' => 'designations.unpublish']);
Route::get('designations/publish/{id}', ['uses' => 'Admin\DesignationsController@publish', 'as' => 'designations.publish']);
Route::get('designations/designation_ajax/{id}', ['uses' => 'Admin\DesignationsController@designation_ajax', 'as' => 'designations.designation_ajax']);
Route::get('designations/{designationid}/filterdesignation/{id}', ['uses' => 'Admin\DesignationsController@filterdesignation', 'as' => 'designations.filterdesignation']);


//------------institute-industry-----//

Route::resource('institutes-industries', 'Admin\InstituteIndustryController');
Route::get('get-institutes-industries-data', ['uses' => 'Admin\InstituteIndustryController@getData', 'as' => 'institutes-industries.get_data']);

Route::get('institutes-industries/unpublish/{id}', ['uses' => 'Admin\InstituteIndustryController@unpublish', 'as' => 'institutes-industries.unpublish']);
Route::get('institutes-industries/publish/{id}', ['uses' => 'Admin\InstituteIndustryController@publish', 'as' => 'institutes-industries.publish']);


//------------banners-----//

Route::resource('banners', 'Admin\BannersController');
Route::get('get-banners-data', ['uses' => 'Admin\BannersController@getData', 'as' => 'banners.get_data']);
Route::get('banners/publish/{id}', ['uses' => 'Admin\BannersController@publish', 'as' => 'banners.publish']);
Route::get('banners/unpublish/{id}', ['uses' => 'Admin\BannersController@unpublish', 'as' => 'banners.unpublish']);


//------------------elitedashboard----------------------------//
Route::resource('elitedashboard', 'Admin\ElitedashboardController');
Route::get('elitedashboard_chart', ['uses' => 'Admin\ElitedashboardController@elitedashboard_chart', 'as' => 'elitedashboard.elitedashboard_chart']);
Route::get('elitedashboard_analytics', ['uses' => 'Admin\ElitedashboardController@elitedashboard_analytics', 'as' => 'elitedashboard.elitedashboard_analytics']);
Route::get('eliteTab-ajax/{id}', ['uses' => 'Admin\ElitedashboardController@eliteTabFilter', 'as' => 'elitedashboard.eliteTab-ajax']);
Route::get('get-elitedashboard_chart-data', ['uses' => 'Admin\ElitedashboardController@getChartData', 'as' => 'elitedashboard_chart.get_data']);
Route::get('elitedashboard_chart/chart-ajax/{id}', ['uses' => 'Admin\ElitedashboardController@chart_ajax', 'as' => 'elitedashboard_chart.chart-ajax']);
Route::get('elitedashboard_chart/chart1user-ajax/{id}', ['uses' => 'Admin\ElitedashboardController@chart1user_ajax', 'as' => 'elitedashboard_chart.chart1user-ajax']);
Route::get('elitedashboard_chart/chart2user-ajax/{id}', ['uses' => 'Admin\ElitedashboardController@chart2user_ajax', 'as' => 'elitedashboard_chart.chart2user-ajax']);
Route::get('elitedashboard_chart/userAttendedTraining-ajax/{id}', ['uses' => 'Admin\ElitedashboardController@userAttendedTraining_ajax', 'as' => 'elitedashboard_chart.userAttendedTraining-ajax']);
//Route::get('elitedashboard_chart/tabularReport-ajax/', ['uses' => 'Admin\ElitedashboardController@tabularReportFiletr', 'as' => 'elitedashboard_chart.tabularReport-ajax']);
Route::get('tabularReport-data', ['uses' => 'Admin\ElitedashboardController@getData', 'as' => 'elitedashboard_chart.get_data']);

//------------------mycourse----------------------------//
Route::resource('mycourse', 'Admin\MycourseController');
Route::get('completedcourses', ['uses' => 'Admin\MycourseController@completedcourses', 'as' => 'mycourse.completedcourses']);
Route::get('ongoingcourses', ['uses' => 'Admin\MycourseController@ongoingcourses', 'as' => 'mycourse.ongoingcourses']);
Route::post('completeMoodle', ['uses' => 'Admin\MycourseController@completeMoodle', 'as' => 'mycourse.completeMoodle']);
Route::get('inprogress', ['uses' => 'Admin\MycourseController@inprogress', 'as' => 'mycourse.inprogress']);
Route::get('completed', ['uses' => 'Admin\MycourseController@completed', 'as' => 'mycourse.completed']);


//===== Categories Routes =====//
Route::resource('categories', 'Admin\CategoriesController');
Route::get('get-categories-data', ['uses' => 'Admin\CategoriesController@getData', 'as' => 'categories.get_data']);
Route::post('categories_mass_destroy', ['uses' => 'Admin\CategoriesController@massDestroy', 'as' => 'categories.mass_destroy']);
Route::post('categories_restore/{id}', ['uses' => 'Admin\CategoriesController@restore', 'as' => 'categories.restore']);
Route::delete('categories_perma_del/{id}', ['uses' => 'Admin\CategoriesController@perma_del', 'as' => 'categories.perma_del']);


Route::get('categories/unpublish/{id}', ['uses' => 'Admin\CategoriesController@unpublish', 'as' => 'categories.unpublish']);
Route::get('categories/publish/{id}', ['uses' => 'Admin\CategoriesController@publish', 'as' => 'categories.publish']);

Route::get('categories/office-ajax/{id}', ['uses' => 'Admin\CategoriesController@officeFilter', 'as' => 'categories.office-ajax']);
//Route::get('categories/track-ajax/{id}', ['uses' => 'Admin\CategoriesController@trackFilter', 'as' => 'categories.track-ajax']);


	//===== Courses Routes =====//
// Route::post('courses/create/scrom', 'Admin\CoursesController@createScrom');
Route::post('courses/course-store', 'Admin\CoursesController@store');


//===== Courses Routes =====//
Route::resource('courses', 'Admin\CoursesController');
Route::resource('courses-scrom', 'Admin\CoursesScromController');
Route::get('get-courses-data', ['uses' => 'Admin\CoursesController@getData', 'as' => 'courses.get_data']);
Route::post('courses_mass_destroy', ['uses' => 'Admin\CoursesController@massDestroy', 'as' => 'courses.mass_destroy']);
Route::post('courses_restore/{id}', ['uses' => 'Admin\CoursesController@restore', 'as' => 'courses.restore']);
Route::delete('courses_perma_del/{id}', ['uses' => 'Admin\CoursesController@perma_del', 'as' => 'courses.perma_del']);
Route::post('course-save-sequence', ['uses' => 'Admin\CoursesController@saveSequence', 'as' => 'courses.saveSequence']);
Route::get('course-publish/{id}',['uses' => 'Admin\CoursesController@publish' , 'as' => 'courses.publish']);

Route::get('courses/subcat-ajax/{id}', ['uses' => 'Admin\CoursesController@subcatFilter', 'as' => 'courses.subcat-ajax']);


Route::get('courses/department-ajax/{id}', ['uses' => 'Admin\CoursesController@departmentFilter', 'as' => 'courses.department-ajax']);
Route::get('courses/designation-ajax/{id}',['uses' => 'Admin\CoursesController@departmentdesignation' , 'as' => 'courses.departmentdesignation']);

Route::get('courses/{courseid}/designationedit-ajax/{id}',['uses' => 'Admin\CoursesController@designationedit' , 'as' => 'courses.designationedit']);



//===== Course Allotment Routes =====//
Route::resource('course_allotment', 'Admin\CourseAllotmentController');
Route::get('get-course-allotment', ['uses' => 'Admin\CourseAllotmentController@getCourseAllotment', 'as' => 'course_allotment.get_course_allotment']);
Route::get('course_allotment/track-ajax/{id}', ['uses' => 'Admin\CourseAllotmentController@trackFilter', 'as' => 'courses.track-ajax']);
Route::get('course_allotment/category-ajax/{id}', ['uses' => 'Admin\CourseAllotmentController@categoryFilter', 'as' => 'courses.category-ajax']);
Route::get('course_allotment/subcat-ajax/{id}', ['uses' => 'Admin\CourseAllotmentController@subcatFilter', 'as' => 'courses.subcat-ajax']);
Route::get('course_allotment/course-ajax/{departmentID}/{trackID}/{categoryID}/{subcatID}/{levelID}', ['uses' => 'Admin\CourseAllotmentController@courseFilter', 'as' => 'courses.course-ajax']);
Route::get('course_allotment/dept-users-ajax/{id}', ['uses' => 'Admin\CourseAllotmentController@deptusersFilter', 'as' => 'dept-users.subcat-ajax']);
Route::post('course_allotment/store', 'Admin\CourseAllotmentController@store')->name('courseallotment.store');
Route::get('course_allotment/dept-designation-ajax/{id}', ['uses' => 'Admin\CourseAllotmentController@deptdesignationFilter', 'as' => 'courses.deptdesignation-ajax']);
//===== Bundles Routes =====//
Route::resource('bundles', 'Admin\BundlesController');
Route::get('get-bundles-data', ['uses' => 'Admin\BundlesController@getData', 'as' => 'bundles.get_data']);
Route::post('bundles_mass_destroy', ['uses' => 'Admin\BundlesController@massDestroy', 'as' => 'bundles.mass_destroy']);
Route::post('bundles_restore/{id}', ['uses' => 'Admin\BundlesController@restore', 'as' => 'bundles.restore']);
Route::delete('bundles_perma_del/{id}', ['uses' => 'Admin\BundlesController@perma_del', 'as' => 'bundles.perma_del']);
Route::post('bundle-save-sequence', ['uses' => 'Admin\BundlesController@saveSequence', 'as' => 'bundles.saveSequence']);
Route::get('bundle-publish/{id}',['uses' => 'Admin\BundlesController@publish' , 'as' => 'bundles.publish']);



//===== Lessons Routes =====//
Route::resource('lessons', 'Admin\LessonsController');
Route::get('modechange/{id}', ['uses' => 'Admin\LessonsController@modeChange', 'as' => 'lessons.modechange']);
Route::get('get-lessons-data', ['uses' => 'Admin\LessonsController@getData', 'as' => 'lessons.get_data']);
Route::post('lessons_mass_destroy', ['uses' => 'Admin\LessonsController@massDestroy', 'as' => 'lessons.mass_destroy']);
Route::post('lessons_restore/{id}', ['uses' => 'Admin\LessonsController@restore', 'as' => 'lessons.restore']);
Route::delete('lessons_perma_del/{id}', ['uses' => 'Admin\LessonsController@perma_del', 'as' => 'lessons.perma_del']);


//===== Questions Routes =====//
Route::resource('questions', 'Admin\QuestionsController');
Route::get('get-questions-data', ['uses' => 'Admin\QuestionsController@getData', 'as' => 'questions.get_data']);
Route::post('questions_mass_destroy', ['uses' => 'Admin\QuestionsController@massDestroy', 'as' => 'questions.mass_destroy']);
Route::post('questions_restore/{id}', ['uses' => 'Admin\QuestionsController@restore', 'as' => 'questions.restore']);
Route::delete('questions_perma_del/{id}', ['uses' => 'Admin\QuestionsController@perma_del', 'as' => 'questions.perma_del']);


//===== Questions Options Routes =====//
Route::resource('questions_options', 'Admin\QuestionsOptionsController');
Route::get('get-qo-data', ['uses' => 'Admin\QuestionsOptionsController@getData', 'as' => 'questions_options.get_data']);
Route::post('questions_options_mass_destroy', ['uses' => 'Admin\QuestionsOptionsController@massDestroy', 'as' => 'questions_options.mass_destroy']);
Route::post('questions_options_restore/{id}', ['uses' => 'Admin\QuestionsOptionsController@restore', 'as' => 'questions_options.restore']);
Route::delete('questions_options_perma_del/{id}', ['uses' => 'Admin\QuestionsOptionsController@perma_del', 'as' => 'questions_options.perma_del']);


//===== Tests Routes =====//
Route::resource('tests', 'Admin\TestsController');
Route::get('get-tests-data', ['uses' => 'Admin\TestsController@getData', 'as' => 'tests.get_data']);
Route::post('tests_mass_destroy', ['uses' => 'Admin\TestsController@massDestroy', 'as' => 'tests.mass_destroy']);
Route::post('tests_restore/{id}', ['uses' => 'Admin\TestsController@restore', 'as' => 'tests.restore']);
Route::delete('tests_perma_del/{id}', ['uses' => 'Admin\TestsController@perma_del', 'as' => 'tests.perma_del']);


//===== Media Routes =====//
Route::post('media/remove', ['uses' => 'Admin\MediaController@destroy', 'as' => 'media.destroy']);


//===== User Account Routes =====//
Route::group(['middleware' => ['auth', 'password_expires']], function () {
Route::get('account', [AccountController::class, 'index'])->name('account');
Route::patch('account', [UpdatePasswordController::class, 'update'])->name('account.post');
Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');
});


//==== Messages Routes =====//
Route::get('messages', ['uses' => 'MessagesController@index', 'as' => 'messages']);
Route::post('messages/unread', ['uses' => 'MessagesController@getUnreadMessages', 'as' => 'messages.unread']);
Route::post('messages/send', ['uses' => 'MessagesController@send', 'as' => 'messages.send']);
Route::post('messages/reply', ['uses' => 'MessagesController@reply', 'as' => 'messages.reply']);


//===== Orders Routes =====//
Route::resource('orders', 'Admin\OrderController');
Route::get('get-orders-data', ['uses' => 'Admin\OrderController@getData', 'as' => 'orders.get_data']);
Route::post('orders_mass_destroy', ['uses' => 'Admin\OrderController@massDestroy', 'as' => 'orders.mass_destroy']);
Route::post('orders/complete', ['uses' => 'Admin\OrderController@complete', 'as' => 'orders.complete']);
Route::delete('orders_perma_del/{id}', ['uses' => 'Admin\OrderController@perma_del', 'as' => 'orders.perma_del']);


//=== Invoice Routes =====//
Route::get('invoice/download', ['uses' => 'Admin\InvoiceController@getInvoice', 'as' => 'invoice.download']);
Route::get('invoices', ['uses' => 'Admin\InvoiceController@getIndex', 'as' => 'invoices.index']);


//=== Training Routes =====//
Route::get('upcomingtrainings', ['uses' => 'Admin\TrainingController@getIndex', 'as' => 'trainings.index']);
Route::get('get-trainings-data', ['uses' => 'Admin\TrainingController@getData', 'as' => 'trainings.get_data']);
Route::get('get/trainings-ajax/{id}', ['uses' => 'Admin\TrainingController@departmentFilter', 'as' => 'trainings.section-ajax']);
Route::get('crt-details-ajax/{id}', ['uses' => 'Admin\TrainingController@crtDetailsFilter', 'as' => 'trainings.crt-details-ajax']);
Route::get('check-nomination-ajax/{id}', ['uses' => 'Admin\TrainingController@checkNominationFilter', 'as' => 'trainings.check-nomination-ajax']);
Route::get('trainings/section-ajax/{id}', ['uses' => 'Admin\TrainingController@officeFilter', 'as' => 'trainings.office-ajax']);
Route::get('approved', ['uses' => 'Admin\TrainingController@approved', 'as' => 'trainings.approved']);
Route::get('nominate', ['uses' => 'Admin\TrainingController@nominate', 'as' => 'trainings.nominate']);
Route::get('reject', ['uses' => 'Admin\TrainingController@reject', 'as' => 'trainings.reject']);
Route::get('training_status', ['uses' => 'Admin\TrainingController@training_status', 'as' => 'trainings.training_status']);
Route::get('approved_training', ['uses' => 'Admin\TrainingController@approved_training', 'as' => 'trainings.approved_training']);
Route::get('rejected_training', ['uses' => 'Admin\TrainingController@rejected_training', 'as' => 'trainings.rejected_training']);
Route::get('request_approvel', ['uses' => 'Admin\TrainingController@request_approvel', 'as' => 'trainings.request_approvel']);
Route::get('getApproved', ['uses' => 'Admin\TrainingController@getApproved', 'as' => 'trainings.getApproved']);
Route::get('training_attended', ['uses' => 'Admin\TrainingController@training_attended', 'as' => 'trainings.training_attended']);
Route::get('attended', ['uses' => 'Admin\TrainingController@attended', 'as' => 'trainings.attended']);
Route::get('feedback', ['uses' => 'Admin\TrainingController@feedback', 'as' => 'trainings.feedback']);
Route::get('view', ['uses' => 'Admin\TrainingController@view', 'as' => 'trainings.view']);
Route::get('attendance', ['uses' => 'Admin\TrainingController@attendance', 'as' => 'trainings.attendance']);
Route::get('attendancesave', ['uses' => 'Admin\TrainingController@attendancesave', 'as' => 'trainings.attendancesave']);
Route::get('feedbacksave', ['uses' => 'Admin\TrainingController@feedbacksave', 'as' => 'trainings.feedbacksave']);
Route::get('userattandence/{id}', ['uses' => 'Admin\TrainingController@userattandence', 'as' => 'trainings.userattandence']);



//=== E-Learning Routes =====//
Route::get('learnings', ['uses' => 'Admin\LearningController@getIndex', 'as' => 'learnings.index']);
Route::get('selfenroll', ['uses' => 'Admin\LearningController@selfEnrolled', 'as' => 'learnings.selfenroll']);


//Route::group(['middleware' => 'role:admin'], function () {

//===== Settings Routes =====//
Route::get('settings/general', ['uses' => 'Admin\ConfigController@getGeneralSettings', 'as' => 'general-settings']);
Route::post('settings/general', ['uses' => 'Admin\ConfigController@saveGeneralSettings'])->name('general-settings');
Route::get('settings/usermanual', ['uses' => 'Admin\ConfigController@userManual'])->name('usermanual');
Route::get('settings/contactus', ['uses' => 'Admin\ConfigController@contactUs'])->name('contactus');
Route::get('settings/social', ['uses' => 'Admin\ConfigController@getSocialSettings'])->name('social-settings');
Route::post('settings/social', ['uses' => 'Admin\ConfigController@saveSocialSettings'])->name('social-settings');

Route::get('contact', ['uses' => 'Admin\ConfigController@getContact'])->name('contact-settings');
Route::get('footer', ['uses' => 'Admin\ConfigController@getFooter'])->name('footer-settings');
Route::get('newsletter', ['uses' => 'Admin\ConfigController@getNewsletterConfig'])->name('newsletter-settings');
Route::post('newsletter/sendgrid-lists', ['uses' => 'Admin\ConfigController@getSendGridLists'])->name('newsletter.getSendGridLists');
Route::get('settings/feedback', ['uses' => 'Admin\ConfigController@feedback'])->name('feedback');

////////////////////////addtional default setting///////////////////////

Route::get('settings/default', ['uses' => 'Admin\ConfigController@getDefaultSettings', 'as' => 'default-settings']);
Route::post('settings/default', ['uses' => 'Admin\ConfigController@saveDefaultSettings'])->name('default-settings');

Route::get('settings/department-ajax/{id}', ['uses' => 'Admin\ConfigController@departmentFilter', 'as' => 'default-settings.department-ajax']);



//});



//===== Slider Routes =====/
Route::resource('sliders', 'Admin\SliderController');
Route::get('sliders/status/{id}', 'Admin\SliderController@status')->name('sliders.status', 'id');
Route::post('sliders/save-sequence', ['uses' => 'Admin\SliderController@saveSequence', 'as' => 'sliders.saveSequence']);


//===== Sponsors Routes =====//
Route::resource('sponsors', 'Admin\SponsorController');
Route::get('get-sponsors-data', ['uses' => 'Admin\SponsorController@getData', 'as' => 'sponsors.get_data']);
Route::post('sponsors_mass_destroy', ['uses' => 'Admin\SponsorController@massDestroy', 'as' => 'sponsors.mass_destroy']);
Route::get('sponsors/status/{id}', 'Admin\SponsorController@status')->name('sponsors.status', 'id');


//===== Testimonials Routes =====//
Route::resource('testimonials', 'Admin\TestimonialController');
Route::get('get-testimonials-data', ['uses' => 'Admin\TestimonialController@getData', 'as' => 'testimonials.get_data']);
Route::post('testimonials_mass_destroy', ['uses' => 'Admin\TestimonialController@massDestroy', 'as' => 'testimonials.mass_destroy']);
Route::get('testimonials/status/{id}', 'Admin\TestimonialController@status')->name('testimonials.status', 'id');


//======= Blog Routes =====//
Route::group(['prefix' => 'blog'], function () {
Route::get('/create', 'Admin\BlogController@create');
Route::post('/create', 'Admin\BlogController@store');
Route::get('delete/{id}', 'Admin\BlogController@destroy')->name('blogs.delete');
Route::get('edit/{id}', 'Admin\BlogController@edit')->name('blogs.edit');
Route::post('edit/{id}', 'Admin\BlogController@update');
Route::get('view/{id}', 'Admin\BlogController@show');
//        Route::get('{blog}/restore', 'BlogController@restore')->name('blog.restore');
Route::post('{id}/storecomment', 'Admin\BlogController@storeComment')->name('storeComment');
});
Route::resource('blogs', 'Admin\BlogController');
Route::get('get-blogs-data', ['uses' => 'Admin\BlogController@getData', 'as' => 'blogs.get_data']);
Route::post('blogs_mass_destroy', ['uses' => 'Admin\BlogController@massDestroy', 'as' => 'blogs.mass_destroy']);


//======= Pages Routes =====//
Route::resource('pages', 'Admin\PageController');
Route::get('get-pages-data', ['uses' => 'Admin\PageController@getData', 'as' => 'pages.get_data']);
Route::post('pages_mass_destroy', ['uses' => 'Admin\PageController@massDestroy', 'as' => 'pages.mass_destroy']);
Route::post('pages_restore/{id}', ['uses' => 'Admin\PageController@restore', 'as' => 'pages.restore']);
Route::delete('pages_perma_del/{id}', ['uses' => 'Admin\PageController@perma_del', 'as' => 'pages.perma_del']);


//===== FAQs Routes =====//
Route::resource('faqs', 'Admin\FaqController');
Route::get('get-faqs-data', ['uses' => 'Admin\FaqController@getData', 'as' => 'faqs.get_data']);
Route::post('faqs_mass_destroy', ['uses' => 'Admin\FaqController@massDestroy', 'as' => 'faqs.mass_destroy']);
Route::get('faqs/status/{id}', 'Admin\FaqController@status')->name('faqs.status');



//===== FORUMS Routes =====//
Route::resource('forums-category', 'Admin\ForumController');
Route::get('forums-category/status/{id}', 'Admin\ForumController@status')->name('forums-category.status');


//==== Reasons Routes ====//
Route::resource('reasons', 'Admin\ReasonController');
Route::get('get-reasons-data', ['uses' => 'Admin\ReasonController@getData', 'as' => 'reasons.get_data']);
Route::post('reasons_mass_destroy', ['uses' => 'Admin\ReasonController@massDestroy', 'as' => 'reasons.mass_destroy']);
Route::get('reasons/status/{id}', 'Admin\ReasonController@status')->name('reasons.status');


Route::get('menu-manager', ['uses'=>'MenuController@index','middleware'=>['auth','role:administrator']])->name('menu-manager');


//====== Contacts Routes =====//
Route::resource('contact-requests', 'ContactController');
Route::get('get-contact-requests-data', ['uses' => 'ContactController@getData', 'as' => 'contact_requests.get_data']);

//====== Review Routes =====//
Route::resource('reviews', 'ReviewController');
Route::get('get-reviews-data', ['uses' => 'ReviewController@getData', 'as' => 'reviews.get_data']);


//====== Reports Routes =====//
Route::get('report/sales', ['uses' => 'ReportController@getSalesReport','as' => 'reports.sales']);
Route::get('report/students', ['uses' => 'ReportController@getStudentsReport','as' => 'reports.students']);

Route::get('get-course-reports-data', ['uses' => 'ReportController@getCourseData', 'as' => 'reports.get_course_data']);
Route::get('get-bundle-reports-data', ['uses' => 'ReportController@getBundleData', 'as' => 'reports.get_bundle_data']);
Route::get('get-students-reports-data', ['uses' => 'ReportController@getStudentsData', 'as' => 'reports.get_students_data']);


//====== Tax Routes =====//
Route::resource('tax', 'TaxController');
Route::get('tax/status/{id}', 'TaxController@status')->name('tax.status', 'id');

//====== Coupon Routes =====//
Route::resource('coupons', 'CouponController');
Route::get('coupons/status/{id}', 'CouponController@status')->name('coupons.status', 'id');



//==== Remove Locale FIle ====//
Route::post('delete-locale', function () {
\Barryvdh\TranslationManager\Models\Translation::where('locale', request('locale'))->delete();

\Illuminate\Support\Facades\File::deleteDirectory(public_path('../resources/lang/' . request('locale')));
})->name('delete-locale');


//==== Certificates ====//
Route::get('certificates', 'CertificateController@getCertificates')->name('certificates.index');
Route::post('certificates/generate', 'CertificateController@generateCertificate')->name('certificates.generate');
Route::get('certificates/download', ['uses' => 'CertificateController@download', 'as' => 'certificates.download']);

//====Peer's Completion Status====//
Route::get('peercompstatus', 'Admin\PeercompController@getpeercompstatus')->name('peercompstatus.index');
Route::get('get-peer-data', ['uses' => 'Admin\PeercompController@getData', 'as' => 'peercompstatus.get_data']);
Route::get('peercompstatus/course-ajax/{id}', ['uses' => 'Admin\PeercompController@courseFilter', 'as' => 'peercompstatus.course-ajax']);
//====Course Request====//
Route::get('courserequest', 'CourserequestController@getcourserequest')->name('courserequest.index');
Route::post('courserequest/store', 'CourserequestController@store')->name('courserequest.store');
Route::get('courserequest/category-ajax/{id}', 'CourserequestController@categoryFilter');
Route::get('courserequest/subcategory-ajax/{id}', 'CourserequestController@subcategoryFilter');
Route::get('courserequest/courses-ajax/{id}', 'CourserequestController@coursesFilter');

//====Resource List====//
Route::get('resourceslist', 'Admin\ResourcesController@index')->name('resources.index');
Route::get('resourceslist/submitsuggestion', 'Admin\ResourcesController@submitsuggestion')->name('resources.submitsuggestion');
Route::post('resourceslist/store', 'Admin\ResourcesController@store')->name('resources.store');
Route::get('get-resources-data', ['uses' => 'Admin\ResourcesController@getData', 'as' => 'resources.get_data']);
Route::get('resourceslist/category-ajax/{id}', ['uses' => 'Admin\ResourcesController@categoryFilter', 'as' => 'resources.category-ajax']);
Route::get('resources/unpublish/{id}', ['uses' => 'Admin\ResourcesController@unpublish', 'as' => 'resources.unpublish']);
Route::get('resources/publish/{id}', ['uses' => 'Admin\ResourcesController@publish', 'as' => 'resources.publish']); 

//=== Approval Route====//

Route::get('approvedapprovallist', 'Admin\ApprovalsController@approvedapprovallist')->name('approvals.approvedapprovallist');
Route::get('pendingapprovallist', 'Admin\ApprovalsController@pendingapprovallist')->name('approvals.pendingapprovallist');
Route::get('get-approved-data', ['uses' => 'Admin\ApprovalsController@getApprovedList', 'as' => 'approval.get_approved_data']);
Route::get('get-pending-data', ['uses' => 'Admin\ApprovalsController@getPendingList', 'as' => 'approval.get_pending_data']);
Route::get('approval/reject/{id}', ['uses' => 'Admin\ApprovalsController@reject', 'as' => 'approval.reject']);
Route::get('approval/accept/{id}', ['uses' => 'Admin\ApprovalsController@accept', 'as' => 'approval.accept']); 
//==== Update Theme Routes ====//
Route::get('update-theme','UpdateController@index')->name('update-theme');
Route::post('update-theme','UpdateController@updateTheme')->name('update-files');
Route::post('list-files','UpdateController@listFiles')->name('list-files');
Route::get('backup','BackupController@index')->name('backup');
Route::get('generate-backup','BackupController@generateBackup')->name('generate-backup');

Route::post('backup','BackupController@storeBackup')->name('backup.store');

//===Trouble shoot ====//
Route::get('troubleshoot','Admin\ConfigController@troubleshoot')->name('troubleshoot');

//==== Sitemap Routes =====//
Route::get('sitemap','SitemapController@getIndex')->name('sitemap.index');
Route::post('sitemap','SitemapController@saveSitemapConfig')->name('sitemap.config');
Route::get('sitemap/generate','SitemapController@generateSitemap')->name('sitemap.generate');
