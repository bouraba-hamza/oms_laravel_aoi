<?php

use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| API Routes
|---------------------------------------------------------------    -----------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['middleware' => ['jwt']], function() {

Route::get('interventionsNonFacture', 'FactureDetailInterventionController@index');
Route::post('interventionsNonFacture/arraychecked', 'FactureDetailInterventionController@checkedIntervention');
Route::post('interventionsNonFacture/arraycheckedexiste/{id}', 'FactureDetailInterventionController@checkedInterventionexiste');


//
//    $command=DB::table('movements')->get();
//    dd($command);
});

Route::group(['middleware' => ['jwt']], function() {

Route::get('commandesDisticnt/{id}', 'commande\\commandeController@commandesDisticnt');

});



Route::group(['middleware' => ['jwt']], function() {

Route::get('commandes/', 'commande\\commandeController@index');
Route::post('products/add', 'Product\\ProductsController@store');
Route::post('commandes/add', 'commande\\commandeController@store');
Route::post('commandes/update', 'commande\\commandeController@update');
Route::delete('commandes/del/{id}', 'commande\\commandeController@destroy');


});


// Route::group(['middleware' => ['jwt']], function() {

Route::get('agenda', 'Agenda\\agendaController@index');
Route::post('agenda/add', 'Agenda\\agendaController@store');
Route::post('agenda/update', 'Agenda\\agendaController@update');
Route::get('agenda/checketateventbyidevent/{id}', 'Agenda\\agendaController@checketateventbyidevent');
Route::get('agenda/enabletatcalendar/{id}', 'Agenda\\agendaController@enabletatcalendar');
Route::get('agenda/add_datevue_calendar/{id}/{encoded_date}', 'Agenda\\agendaController@add_datevue_calendar');
Route::get('agenda/add_date_end/{idEvent}/{date_end}', 'Agenda\\agendaController@add_date_end');
Route::get('agenda/upd_dates_start_end/{idEvent}/{date_start}/{date_end}', 'Agenda\\agendaController@upd_dates_start_end');
Route::delete('agenda/del/{id}', 'Agenda\\agendaController@destroy');
Route::get('agenda/show/', 'Agenda\\agendaController@show');
Route::get('agenda/filter/', 'Agenda\\agendaController@filter');
Route::get('agenda/getusers/', 'Agenda\\agendaController@getusers');
Route::get('agenda/getusernamebyid/{id_user}', 'Agenda\\agendaController@getusernamebyid');
Route::get('agenda/get_created_at_byidevent/{id_event}', 'Agenda\\agendaController@get_created_at_byidevent');
Route::get('agenda/geteventsuser/{id_user}', 'Agenda\\agendaController@geteventsuser');
Route::get('agenda/geteventsusersup/{id_user}', 'Agenda\\agendaController@geteventsusersup');
Route::get('agenda/getcountrowseventsuser/{id_user}', 'Agenda\\agendaController@getcountrowseventsuser');
Route::get('agenda/get_count_event_non_vue_by_id_installateur/{id_installateur}', 'Agenda\\agendaController@get_count_event_non_vue_by_id_installateur');
Route::get('agenda/get_count_all_events_non_vues/', 'Agenda\\agendaController@get_count_all_events_non_vues');
Route::get('agenda/findusercalendarpermission/', 'Agenda\\agendaController@findusercalendarpermission');
Route::get('agenda/addcalendarpermission/{id_user}', 'Agenda\\agendaController@addcalendarpermission');
Route::post('agenda/updcalendarpermission', 'Agenda\\agendaController@updcalendarpermission');
Route::get('agenda/refresh_addremove_fakeevent/{id_user}', 'Agenda\\agendaController@refresh_addremove_fakeevent');
Route::get('agenda/getuser_by_mail/{mail}', 'Agenda\\agendaController@getuser_by_mail');

//});


Route::group(['middleware' => ['jwt']], function() {

Route::get('productsBoitier/', 'Product\\ProductsController@indexBoitier');
Route::get('productsSim/', 'Product\\ProductsController@indexSim');
Route::post('products/addSimBoitier', 'Product\\ProductsController@storeSimBoitier');
Route::post('products/update', 'Product\\ProductsController@update');
Route::delete('products/del/{id}', 'Product\\ProductsController@destroy');
Route::post('products/active', 'Product\\ProductsController@active');
Route::post('products/affect', 'Product\\ProductsController@affect');
Route::post('products/transfert', 'Product\\ProductsController@transfert');
Route::post('products/blocage', 'Product\\ProductsController@blocage');
Route::post('products/deblocage', 'Product\\ProductsController@deblocage');
Route::post('products/liberation', 'Product\\ProductsController@liberation');
Route::post('products/retour', 'Product\\ProductsController@retour');
Route::get('productInstallSim/{id}', 'Product\\ProductsController@productInstallSim');
Route::get('ProductStockSim/{id}', 'Product\\ProductsController@ProductStockSim');
Route::get('ProductStockBoitier/{id}', 'Product\\ProductsController@ProductStockBoitier');
Route::get('productInstallBoitier/{id}', 'Product\\ProductsController@productInstallBoitier');


});


Route::group(['middleware' => ['jwt']], function() {

Route::get('plan/{id}', 'plan\\PlansController@index');
Route::post('plan/addPlan', 'plan\\PlansController@store');


});


Route::group(['middleware' => ['jwt']], function() {

Route::get('produits/', 'ProduitController@index');
Route::get('produits/select', 'ProduitController@select');
Route::get('produits/service','ProduitController@indexService');
Route::post('produits/add', 'ProduitController@store');
Route::delete('/produits/del/{id}', 'ProduitController@destroy');
Route::delete('/produits/up/{id}', 'ProduitController@updateProduit');
Route::post('/produits/update', 'ProduitController@update');


});




Route::group(['middleware' => ['jwt']], function() {

Route::get('banque/', 'BanqueController@index');
//Route::get('produits/service','ProduitController@indexService');
Route::post('banque/add', 'BanqueController@store');
Route::delete('/banque/del/{id}', 'BanqueController@destroy');
Route::post('/banque/update', 'BanqueController@update');


});

Route::get('instalateur/', 'installer\\InstallersController@index');

// Route::group(['middleware' => ['jwt']], function() {

Route::get('/costumer', 'costumer\\CostumerController@index') ;
Route::post('costumer/add', 'costumer\\CostumerController@store');
Route::delete('/costumer/del/{id}', 'costumer\\CostumerController@destroy');
Route::post('costumer/update', 'costumer\\CostumerController@update');



// });
//Route::get('/utilisateur', 'utilisateur\\UtilisateurController@index');
//Route::post('utilisateur/add', 'utilisateur\\UtilisateurController@store');
//Route::post('utilisateur/update', 'utilisateur\\UtilisateurController@update');



Route::group(['middleware' => ['jwt']], function() {

Route::get('/provider', 'provider\\ProviderController@index')  ;
Route::get('/provider/{id}', 'provider\\ProviderController@indexByIdCategorie');
Route::post('provider/add', 'provider\\ProviderController@store') ;
Route::delete('/provider/del/{id}', 'provider\\ProviderController@destroy') ;
Route::post('provider/update', 'provider\\ProviderController@update') ;

});





Route::group(['middleware' => ['jwt']], function() {

Route::get('/personals', 'personals\\PersonalController@index');
Route::get('/personals/{id}', 'personals\\PersonalController@indexIntervention');


});


//Route::get('/Personaldetail', 'Personaldetail\\PersonalDetailsController@index');
//Route::post('Personaldetail/detail', 'Personaldetail\\PersonalDetailsController@getDetailPersonal');



Route::group(['middleware' => ['jwt']], function() {

Route::get('FactureProvider/', 'FactureProviderController@index');
Route::delete('/FactureProvider/del/{id}', 'FactureProviderController@destroy');
Route::post('FactureProvider/add', 'FactureProviderController@store');
Route::post('/FactureProvider/update', 'FactureProviderController@update');
Route::get('/FactureProvider/calcule/{id}','FactureProviderController@FactureMontant');
Route::get('/FactureProvider/{id}','FactureProviderController@getFacture');
Route::get('LigneFactureIntervention/{id}','LigneFactureClientController@indexLigneFactureIntervention');
Route::get('LigneFactureIntervention/calcule/{id}','LigneFactureClientController@FactureMontant');
Route::post('LigneFactureIntervention/update','LigneFactureClientController@update');


});


Route::group(['middleware' => ['jwt']], function() {

Route::get('FactureClient/', 'FactureClientController@index');
Route::get('FactureClient/indexIntervetion', 'FactureClientController@indexIntervetion');
Route::get('FactureClient/pdf/{id}', 'FactureClientController@toPdf');
Route::get('FactureClientIntervention/pdf/{id}', 'FactureClientController@toPdfIntervention');
Route::delete('/FactureClient/del/{id}', 'FactureClientController@destroy');
Route::delete('/FactureClient/close/{id}', 'FactureClientController@close');
Route::post('FactureClient/add', 'FactureClientController@store');
Route::post('/FactureClient/update', 'FactureClientController@update');
Route::get('/FactureClient/calcule/{id}','FactureClientController@FactureMontant');
Route::get('/FactureClient/{id}','FactureClientController@getFacture');
Route::get('/FactureClient/client/{id}','FactureClientController@getFactureExiste');


});




Route::group(['middleware' => ['jwt']], function() {

Route::get('DevisClient/', 'DevisClientController@index');
Route::delete('/DevisClient/del/{id}', 'DevisClientController@destroy');
Route::delete('/DevisClient/facture/{id}', 'DevisClientController@facture');
Route::post('DevisClient/add', 'DevisClientController@store');
Route::post('/DevisClient/update', 'DevisClientController@update');
Route::get('/DevisClient/calcule/{id}','DevisClientController@FactureMontant');
Route::get('/DevisClient/{id}','DevisClientController@getFacture');


});





Route::group(['middleware' => ['jwt']], function() {

Route::get('LigneFacture/','LigneFactureProviderController@index');
Route::get('LigneFacture/{id}','LigneFactureProviderController@indexLigneFacture');
Route::post('LigneFacture/add', 'LigneFactureProviderController@store');
Route::delete('LigneFacture/del/{id}', 'LigneFactureProviderController@destroy');


});





Route::group(['middleware' => ['jwt']], function() {

Route::get('LigneFactureClient/','LigneFactureClientController@index');
Route::get('LigneFactureClient/','LigneFactureClientController@index');
Route::get('LigneFactureClient/{id}','LigneFactureClientController@indexLigneFacture');
Route::post('LigneFactureClient/add', 'LigneFactureClientController@store');
Route::delete('LigneFactureClient/del/{id}', 'LigneFactureClientController@destroy');


});




Route::group(['middleware' => ['jwt']], function() {

Route::get('LigneDevisClient/','LigneDevisClientController@index');
Route::get('LigneDevisClient/{id}','LigneDevisClientController@indexLigneFacture');
Route::post('LigneDevisClient/add', 'LigneDevisClientController@store');
Route::delete('LigneDevisClient/del/{id}', 'LigneDevisClientController@destroy');


});





Route::group(['middleware' => ['jwt']], function() {

Route::get('/ReglementProvider/{id}','ReglementProviderController@indexFactureProvider');
Route::post('ReglementProvider/add', 'ReglementProviderController@store');
Route::delete('/ReglementProvider/del/{id}', 'ReglementProviderController@destroy');
Route::get('/ReglementProvider/calcule/{id}','ReglementProviderController@ReglementFacture');
Route::get('ReglementProvider/','ReglementProviderController@index');


});



Route::group(['middleware' => ['jwt']], function() {

Route::get('/ReglementClient/{id}','ReglementClientController@indexFactureProvider');
Route::post('ReglementClient/add', 'ReglementClientController@store');
Route::delete('/ReglementClient/del/{id}', 'ReglementClientController@destroy');
Route::post('ReglementClient/search', 'ReglementClientController@search');
Route::get('/ReglementClient/calcule/{id}','ReglementClientController@ReglementFacture');
Route::get('ReglementClient/','ReglementClientController@index');


});




Route::group(['middleware' => ['jwt']], function() {

Route::get('/v', 'Vehicle\\VehiclesController@getV');
Route::get('/vehicule', 'Vehicle\\VehiclesController@index');
Route::post('/vehiculeAll', 'Vehicle\\VehiclesController@show');
Route::post('/vehicule/add', 'Vehicle\\VehiclesController@store');
Route::delete('/vehicule/del/{id}', 'Vehicle\\VehiclesController@destroy');
Route::post('vehicule/update', 'Vehicle\\VehiclesController@update');


});


Route::group(['middleware' => ['jwt']], function() {

Route::get('installers', 'Installer\\InstallersController@index');
Route::post('installers', 'Installer\\InstallersController@store');
Route::put('installers/{installer}', 'Installer\\InstallersController@update');
Route::delete('installers/{installer}', 'Installer\\InstallersController@delete');


});
//Route::get('/Journalisation', 'Journalisation\\JournalisationController@indexService');
//Route::post('/Journalisation', 'Journalisation\\JournalisationController@index');


Route::group(['middleware' => ['jwt']], function() {

Route::get('/SchemaVehicule', 'SchemaVehicule\\SchemaController@index');
Route::post('SchemaVehicule/add', 'SchemaVehicule\\SchemaController@store');
Route::delete('/SchemaVehicule/del/{id}', 'SchemaVehicule\\SchemaController@destroy');
Route::post('SchemaVehicule/update', 'SchemaVehicule\\SchemaController@update');


});





Route::group(['middleware' => ['jwt']], function() {

Route::get('/TypesCustomer', 'TypesCustomer\\TypesCustomerController@index');
Route::get('/TypesCustomer/find/{label_type}', 'TypesCustomer\\TypesCustomerController@find');
Route::post('TypesCustomer/add', 'TypesCustomer\\TypesCustomerController@store');
Route::delete('/TypesCustomer/del/{id}', 'TypesCustomer\\TypesCustomerController@destroy');
Route::post('TypesCustomer/update', 'TypesCustomer\\TypesCustomerController@update');


});

Route::group(['middleware' => ['jwt']], function() {

Route::get('/personals', 'personnel\\personnelController@index');
Route::post('/personals/add', 'personnel\\personnelController@store');
Route::delete('/personals/del/{id}', 'personnel\\personnelController@destroy');
Route::post('personals/update', 'personnel\\personnelController@update');



});


Route::group(['middleware' => ['jwt']], function() {

Route::get('/TypesProvider', 'TypesProvider\\TypesProviderController@index');
Route::post('TypesProvider/add', 'TypesProvider\\TypesProviderController@store');
Route::delete('/TypesProvider/del/{id}', 'TypesProvider\\TypesProviderController@destroy');
Route::post('TypesProvider/update', 'TypesProvider\\TypesProviderController@update');


});



Route::group(['middleware' => ['jwt']], function() {

Route::get('/TypesUtilisateur', 'TypesUtilisateur\\TypesUtilisateurController@index');
Route::post('TypesUtilisateur/add', 'TypesUtilisateur\\TypesUtilisateurController@store');
Route::delete('/TypesUtilisateur/del/{id}', 'TypesUtilisateur\\TypesUtilisateurController@destroy');
Route::post('TypesUtilisateur/update', 'TypesUtilisateur\\TypesUtilisateurController@update');


});


Route::group(['middleware' => ['jwt']], function() {
Route::get('/Modele', 'Modele\\ModeleController@index');
Route::post('Modele/add', 'Modele\\ModeleController@store');
Route::delete('/Modele/del/{id}', 'Modele\\ModeleController@destroy');
Route::post('Modele/update', 'Modele\\ModeleController@update');

});


Route::group(['middleware' => ['jwt']], function() {
Route::get('/Marque', 'Marque\\MarqueController@index');
Route::post('Marque/add', 'Marque\\MarqueController@store');
Route::delete('/Marque/del/{id}', 'Marque\\MarqueController@destroy');
Route::post('Marque/update', 'Marque\\MarqueController@update');



});
// Route::get('installerproducts', 'Installersproduct\\InstallersproductController@index');
// Route::post('installerproducts', 'Installersproduct\\InstallersproductController@store');
// Route::put('installerproducts/{installerproduct}', 'Installersproduct\\InstallersproductController@update');
// Route::delete('installerproducts/{installerproduct}', 'Installersproduct\\InstallersproductController@delete');

Route::group(['middleware' => ['jwt']], function() {

Route::get('interventions', 'Intervention\\InterventionsController@index');
Route::post('interventions/filter', 'Intervention\\InterventionsController@filter');
Route::post('interventions/add', 'Intervention\\InterventionsController@store');
Route::post('interventions/update', 'Intervention\\InterventionsController@update');
Route::post('interventions/edit', 'Intervention\\InterventionsController@edit');
Route::delete('interventions/del/{id}', 'Intervention\\InterventionsController@destroy');
Route::delete('interventions/detail_intervention/del/{id}', 'Intervention\\InterventionsController@destroy_detail_intervention');
Route::post('interventions/verify_for_add', 'Intervention\\InterventionsController@verify');
Route::post('interventions/produits', 'Intervention\\InterventionsController@bigJoin');
Route::post('interventions/detail', 'Intervention\\InterventionsController@getDetailIntervention');
Route::get('interventions/getPdf/{id}', 'Intervention\\InterventionsController@toPdf');
Route::post('interventions/update_line', 'Intervention\\InterventionsController@update_line');
Route::post('interventions/add_detail', 'Intervention\\InterventionsController@add_detail');
Route::post('interventions/store_in_session', 'Intervention\\InterventionsController@storeInStorage');
Route::post('interventions/getSim', 'Intervention\\InterventionsController@getSim');
Route::post('interventions/getBox', 'Intervention\\InterventionsController@getBox');
Route::get('interventions/movement/{categorie}', 'Intervention\\InterventionsController@getMovement');
Route::get('interventions/plan/{categorie}', 'Intervention\\InterventionsController@getPlan');


});

Route::post('register', 'AuthController@register');


Route::post('login', 'AuthController@login');
Route::post('recover', 'AuthController@recover');



Route::group(['middleware' => ['jwt']], function() {

    Route::get('utilisateur/', 'utilisateur\\UtilisateurController@index')     ;
    Route::post('utilisateur/add', 'utilisateur\\UtilisateurController@store' )  ;
    Route::delete('/utilisateur/del/{id}', 'utilisateur\\UtilisateurController@destroy')  ;
    Route::post('/utilisateur/update', 'utilisateur\\UtilisateurController@update')  ;
    Route::get('logout', 'AuthController@logout');


});




