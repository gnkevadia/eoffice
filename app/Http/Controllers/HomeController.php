<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Region;
use App\Models\Pages;
use App\Models\City;
use App\Models\Area;
use App\Models\Setting;
use App\Models\ContactUs;
use App\Models\Coupon;
use App\Models\Booking;
use App\Models\Corporate;
use App\Models\FeedBack;
use App\Http\Controllers\Admin\InventoryController;
use App\Library\Common;
use Session;
use Validator;
use Lang;
use Mail;
use DB;
use PDF;
use App\Models\Terminal;
use App\Models\RequestDemo;
use App\Models\Industries;
use App\Models\News;
use App\Models\Faq;
use App\Models\Users;
use App\Models\Package;
use App\Models\Menu;
use App\Models\Reports;
use App\Models\CustomReports;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\EmailTemplates;
use Stripe\Stripe;
use App\Helpers\StripeHelper;
use App\Models\StripeTransactions;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Redis\Connectors\PredisConnector;
use Illuminate\Support\Facades\Session as FacadesSession;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $data = $request->input();
        if (isset($data['city_id']) && !empty($data['city_id']) && isset($data['city_name']) && !empty($data['city_name'])) {
            Session::put('city_id', $data['city_id']);
            Session::put('city_name', $data['city_name']);
            return redirect($_SERVER['HTTP_REFERER']);
        }

        if (isset($data) && !empty($data) && $request->isMethod('post')) {
            $messages = [
                'name.required' => 'Please specify Name',
                'name.regex' => 'Name cannot have character other than a-z AND A-Z and special character.',
                'email.required' => 'Please specify email',
                'email.email' => 'Please specify valid email',
                'tel.required' => 'Please specify phone',
                'subject.required' => 'Please specify subject',
            ];

            $regxvalidator = [
                'name' => 'required | regex:/^[a-zA-Z0-9 ?!@#\$%\^\&*\)\(+=._-]*$/',
                'email' => 'required|email',
                'tel' => 'required',
                'subject' => 'required'
            ];
            $validator = Validator::make($request->all(), $regxvalidator, $messages);
            if ($validator->fails()) {
                $msg = $validator->errors()->all();
                $msg = implode('<br>', $msg);
                Session::flash('flash_error', $msg);
                return redirect('/')->withInput();
            } else {
                $objModel = new ContactUs;
                $request->merge(["created_by" => Session::get('id')]);
                $objModel->insert($request->except(['_token']));
                Common::defineDynamicConstant('ContactUs');

                $dbEmailTemplates = new EmailTemplates;
                $emialTemplates = $dbEmailTemplates->where(['deleted' => 0, 'slug' => 'thank-you'])->first();
                $emailData = [
                    'siteURL' => url('/'),
                    'VisitorName' => $data['name'],
                ];

                $parsed = $emialTemplates->parse($emailData);
                Mail::send([], [], function ($message) use ($emialTemplates, $data, $parsed) {
                    $message->to($data['email'])
                        ->subject('Ho! Ho! Ho! Thank you for contacting us.')
                        ->from('hello@FuelTrend.com', 'FuelTrend')
                        ->setBody($parsed, 'text/html');
                });

                $emialTemplates = $dbEmailTemplates->where(['deleted' => 0, 'slug' => 'admin-thank-you'])->first();
                $emailData = [
                    'siteURL' => url('/'),
                    'VisitorName' => $data['name'],
                    'VisitorMobileNo' => $data['tel'],
                    'VisitorEmail' => $data['email'],
                    'VisitorSubject' => $data['subject'],
                    'VisitorMessage' => $data['message'],
                ];

                $parsed = $emialTemplates->parse($emailData);
                Mail::send([], [], function ($message) use ($emialTemplates, $data, $parsed) {

                    $message->to(['aashil@dimensions360.in', 'krupal@dimensions360.in', 'prity@d360marcom.com', 'deepal@d360marcom.com', 'mihikashah07@gmail.com', 'tmauni16@gmail.com', 'hello@FuelTrend.com', 'jaishalg@gmail.com'])
                        ->subject('Ho! Ho! Ho! ' . $data['name'] . ' has Contacted!')
                        ->from('hello@FuelTrend.com', 'FuelTrend')
                        ->setBody($parsed, 'text/html');
                });

                return redirect('/thank-you')->with(FLASH_MESSAGE_SUCCESS, 'Thank you for reaching us. We will contact you soon.');
            }
        }

        $dbBanner = new Banner();
        $dynamicWhere = ' status = 1 AND deleted = 0 ';
        $orderby = '';
        $arrBanners = $dbBanner->getAll($orderby, $where = array(), $dynamicWhere);

        $dbFeedBack = new FeedBack();
        $dynamicWhere = ' status = 1 AND deleted = 0 ';
        $orderby = '';
        $arrFeedBack = $dbFeedBack->getAll($orderby, $where = array(), $dynamicWhere);

        $arrFile = array('name' => 'media_file', 'type' => 'file', 'resize' => '', 'path' => 'images/package/', 'predefine' => '', 'except' => 'file_exist', 'existing' => '');

        $dbRegion = new Region();
        $dynamicWhere = ' status = 1 AND deleted = 0 ';
        $orderby = '';
        $arrRegions = $dbRegion->getAll($orderby, $where = array(), $dynamicWhere);

        $dbIndustries = new Industries();
        $dynamicWhere = ' status = 1 AND deleted = 0 ';
        $orderby = '';
        $arrIndustries = $dbIndustries->getAll($orderby, $where = array(), $dynamicWhere);

        $dbNews = new News();
        $dynamicWhere = ' status = 1 AND deleted = 0 ';
        $orderby = '';
        $arrNews = $dbNews->getAll($orderby, $where = array(), $dynamicWhere);

        $dbPages = new Pages();
        $arrHomePageAboutBlock = $dbPages->where(['pages.deleted' => 0, 'page_id' => 25])->get();
        $arrHomePageSolutionBlock = $dbPages->where(['pages.deleted' => 0, 'page_id' => 26])->get();
        $arrHomePageGetStartedBlock = $dbPages->where(['pages.deleted' => 0, 'page_id' => 27])->get();
        $arrHomePageResourcesBlock = $dbPages->where(['pages.deleted' => 0, 'page_id' => 28])->get();

        $arrRights[91001] = '/about-us';
        $arrRights[91001] = '/terms-conditions';
        Session::put('routes', $arrRights);

        $title = 'FuelTrend';
        $keywords = 'FuelTrend, Petrochemical, Gasoline';
        $description = 'Chemical products obtained from petroleum by refining.';
        return view('home', compact('arrRegions', 'arrBanners', 'arrFile', 'title', 'keywords', 'description', 'arrFeedBack', 'arrHomePageAboutBlock', 'arrHomePageSolutionBlock', 'arrHomePageGetStartedBlock', 'arrHomePageResourcesBlock', 'arrIndustries', 'arrNews'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Render
     */
    public function setCity(Request $request)
    {
        $data = $request->input();
        Session::put('city_id', $data['city_id']);
        Session::put('city_name', $data['city_name']);

        $arrResult['result'] = $data['city_name'];
        echo json_encode($arrResult);
        die;
    }

    public function cms(Request $request, $slug)
    {
        Common::getSettings();

        $dbPages = new Pages;
        $dbMenus = new Menu();
        $menus = $dbMenus->where(['menus.deleted' => 0, 'alias' => $slug])->first();
        if (!empty($menus['package_cms_id'])) {
            $pages = $dbPages->where(['pages.deleted' => 0, 'page_id' => $menus['package_cms_id']])->whereNotIn('type_id', [4])->first();
        } else {
            $pages = $dbPages->where(['pages.deleted' => 0, 'alias' => $slug])->whereNotIn('type_id', [4])->first();
        }
        
       $pageName = ucwords(str_replace('-',' ',$slug));
       
        $dbPackage = new Package();
        $package = $dbPackage->where(['package.deleted' => 0, 'alias' => $slug])->first();

        $dbNews = new News();
        $newsList = $dbNews->where(['news.deleted' => 0, 'alias' => $slug])->first();

        $dbIndustries = new Industries();
        $industriesList = $dbIndustries->where(['industries.deleted' => 0, 'alias' => $slug])->first();

        if (isset($pages) && !empty($pages)) {
            $title = "404";
            $keywords = "Page not found";
            $description = "404 - Page not found";

            if (!isset($pages) && empty($pages)) {
                return response()->view('errors.404', compact('title', 'keywords', 'description'));
            }

            if (isset($pages->title) && !empty($pages->title)) {
                $title = $pages->title;
            } else {
                $title = $pages->page_name;
            }

            if (isset($pages->keywords) && !empty($pages->keywords)) {
                $keywords = $pages->keywords;
            } else {
                $keywords = '';
            }

            if (isset($pages->page_description) && !empty($pages->page_description)) {
                $description = $pages->page_description;
            } else {
                $description = '';
            }

            $arrFile = array('name' => 'media_file', 'type' => 'file', 'resize' => '', 'path' => 'images/pages/', 'predefine' => '', 'except' => 'file_exist');
            $featureImageMobile = $featureImage = '';
            if (isset($pages->media_file) && !empty($pages->media_file)) {
                if (isset($arrFile['resize']) && !empty($arrFile['resize'])) {
                    $featureImage = url($arrFile['path'] . $arrFile['resize'] . 'x' . $arrFile['resize'] . '/' . $pages->media_file);
                    if (isset($pages->m_media_file) && !empty($pages->m_media_file)) {
                        $featureImageMobile = url($arrFile['path'] . $arrFile['resize'] . 'x' . $arrFile['resize'] . '/' . $pages->m_media_file);
                    } else {
                        $featureImageMobile = url($arrFile['path'] . $arrFile['resize'] . 'x' . $arrFile['resize'] . '/' . $pages->media_file);
                    }
                } else {
                    $featureImage = url($arrFile['path'] . '/' . $pages->media_file);
                    if (isset($pages->m_media_file) && !empty($pages->m_media_file)) {
                        $featureImageMobile = url($arrFile['path'] . '/' . $pages->m_media_file);
                    } else {
                        $featureImageMobile = url($arrFile['path'] . '/' . $pages->media_file);
                    }
                }
            }

            $dbRegion = new Region();
            $dynamicWhere = ' status = 1 AND deleted = 0 ';
            $orderby = '';
            $arrRegions = $dbRegion->getAll($orderby, $where = array(), $dynamicWhere);
        } elseif (isset($package) && !empty($package)) {
            $pages = $dbPackage->where(['package.deleted' => 0, 'alias' => $slug])->first();

            $title = "404";
            $keywords = "Page not found";
            $description = "404 - Page not found";
            if (!isset($pages) && empty($pages)) {
                return response()->view('errors.404', compact('title', 'keywords', 'description'));
            }

            if (isset($pages->title) && !empty($pages->title)) {
                $title = $pages->title;
            } else {
                $title = $pages->page_name;
            }

            if (isset($pages->keywords) && !empty($pages->keywords)) {
                $keywords = $pages->keywords;
            } else {
                $keywords = '';
            }

            if (isset($pages->page_description) && !empty($pages->page_description)) {
                $description = $pages->page_description;
            } else {
                $description = '';
            }

            $arrFile = array('name' => 'media_file', 'type' => 'file', 'resize' => '', 'path' => 'images/pages/', 'predefine' => '', 'except' => 'file_exist');
            $featureImageMobile = $featureImage = '';
            if (isset($pages->media_file) && !empty($pages->media_file)) {
                if (isset($arrFile['resize']) && !empty($arrFile['resize'])) {
                    $featureImage = url($arrFile['path'] . $arrFile['resize'] . 'x' . $arrFile['resize'] . '/' . $pages->media_file);
                    if (isset($pages->m_media_file) && !empty($pages->m_media_file)) {
                        $featureImageMobile = url($arrFile['path'] . $arrFile['resize'] . 'x' . $arrFile['resize'] . '/' . $pages->m_media_file);
                    } else {
                        $featureImageMobile = url($arrFile['path'] . $arrFile['resize'] . 'x' . $arrFile['resize'] . '/' . $pages->media_file);
                    }
                } else {
                    $featureImage = url($arrFile['path'] . '/' . $pages->media_file);
                    if (isset($pages->m_media_file) && !empty($pages->m_media_file)) {
                        $featureImageMobile = url($arrFile['path'] . '/' . $pages->m_media_file);
                    } else {
                        $featureImageMobile = url($arrFile['path'] . '/' . $pages->media_file);
                    }
                }
            }

            $dbRegion = new Region();
            $dynamicWhere = ' status = 1 AND deleted = 0 ';
            $orderby = '';
            $arrRegions = $dbRegion->getAll($orderby, $where = array(), $dynamicWhere);
        } elseif (isset($package) && !empty($package)) {
            $pages = $dbPackage->where(['package.deleted' => 0, 'alias' => $slug])->first();

            $title = "404";
            $keywords = "Page not found";
            $description = "404 - Page not found";
            if (!isset($pages) && empty($pages)) {
                return response()->view('errors.404', compact('title', 'keywords', 'description'));
            }

            if (isset($pages->title) && !empty($pages->title)) {
                $title = $pages->title;
            } else {
                $title = $pages->page_name;
            }

            if (isset($pages->keywords) && !empty($pages->keywords)) {
                $keywords = $pages->keywords;
            } else {
                $keywords = '';
            }

            if (isset($pages->page_description) && !empty($pages->page_description)) {
                $description = $pages->page_description;
            } else {
                $description = '';
            }

            $arrFile = array('name' => 'media_file', 'type' => 'file', 'resize' => '', 'path' => 'images/pages/', 'predefine' => '', 'except' => 'file_exist');
            $featureImageMobile = $featureImage = '';
            if (isset($pages->media_file) && !empty($pages->media_file)) {
                if (isset($arrFile['resize']) && !empty($arrFile['resize'])) {
                    $featureImage = url($arrFile['path'] . $arrFile['resize'] . 'x' . $arrFile['resize'] . '/' . $pages->media_file);
                    if (isset($pages->m_media_file) && !empty($pages->m_media_file)) {
                        $featureImageMobile = url($arrFile['path'] . $arrFile['resize'] . 'x' . $arrFile['resize'] . '/' . $pages->m_media_file);
                    } else {
                        $featureImageMobile = url($arrFile['path'] . $arrFile['resize'] . 'x' . $arrFile['resize'] . '/' . $pages->media_file);
                    }
                } else {
                    $featureImage = url($arrFile['path'] . '/' . $pages->media_file);
                    if (isset($pages->m_media_file) && !empty($pages->m_media_file)) {
                        $featureImageMobile = url($arrFile['path'] . '/' . $pages->m_media_file);
                    } else {
                        $featureImageMobile = url($arrFile['path'] . '/' . $pages->media_file);
                    }
                }
            }
            $dbRegion = new Region();
            $dynamicWhere = ' status = 1 AND deleted = 0 ';
            $orderby = '';
            $arrRegions = $dbRegion->getAll($orderby, $where = array(), $dynamicWhere);
        } elseif (isset($newsList) && !empty($newsList)) {
            $pages = $dbNews->where(['news.deleted' => 0, 'alias' => $slug])->first();

            $title = "404";
            $keywords = "Page not found";
            $description = "404 - Page not found";
            if (!isset($pages) && empty($pages)) {
                return response()->view('errors.404', compact('title', 'keywords', 'description'));
            }

            if (isset($pages->title) && !empty($pages->title)) {
                $title = $pages->title;
            } else {
                $title = $pages->page_name;
            }

            if (isset($pages->keywords) && !empty($pages->keywords)) {
                $keywords = $pages->keywords;
            } else {
                $keywords = '';
            }

            if (isset($pages->page_description) && !empty($pages->page_description)) {
                $description = $pages->page_description;
            } else {
                $description = '';
            }

            $arrFile = array('name' => 'media_file', 'type' => 'file', 'resize' => '', 'path' => 'images/pages/', 'predefine' => '', 'except' => 'file_exist');
            $featureImageMobile = $featureImage = '';
            if (isset($pages->media_file) && !empty($pages->media_file)) {
                if (isset($arrFile['resize']) && !empty($arrFile['resize'])) {
                    $featureImage = url($arrFile['path'] . $arrFile['resize'] . 'x' . $arrFile['resize'] . '/' . $pages->media_file);
                    if (isset($pages->m_media_file) && !empty($pages->m_media_file)) {
                        $featureImageMobile = url($arrFile['path'] . $arrFile['resize'] . 'x' . $arrFile['resize'] . '/' . $pages->m_media_file);
                    } else {
                        $featureImageMobile = url($arrFile['path'] . $arrFile['resize'] . 'x' . $arrFile['resize'] . '/' . $pages->media_file);
                    }
                } else {
                    $featureImage = url($arrFile['path'] . '/' . $pages->media_file);
                    if (isset($pages->m_media_file) && !empty($pages->m_media_file)) {
                        $featureImageMobile = url($arrFile['path'] . '/' . $pages->m_media_file);
                    } else {
                        $featureImageMobile = url($arrFile['path'] . '/' . $pages->media_file);
                    }
                }
            }
            $dbRegion = new Region();
            $dynamicWhere = ' status = 1 AND deleted = 0 ';
            $orderby = '';
            $arrRegions = $dbRegion->getAll($orderby, $where = array(), $dynamicWhere);
        } elseif (isset($industriesList) && !empty($industriesList)) {
            $pages = $dbIndustries->where(['industries.deleted' => 0, 'alias' => $slug])->first();

            $title = "404";
            $keywords = "Page not found";
            $description = "404 - Page not found";
            if (!isset($pages) && empty($pages)) {
                return response()->view('errors.404', compact('title', 'keywords', 'description'));
            }

            if (isset($pages->title) && !empty($pages->title)) {
                $title = $pages->title;
            } else {
                $title = $pages->page_name;
            }

            if (isset($pages->keywords) && !empty($pages->keywords)) {
                $keywords = $pages->keywords;
            } else {
                $keywords = '';
            }

            if (isset($pages->page_description) && !empty($pages->page_description)) {
                $description = $pages->page_description;
            } else {
                $description = '';
            }

            $arrFile = array('name' => 'media_file', 'type' => 'file', 'resize' => '', 'path' => 'images/pages/', 'predefine' => '', 'except' => 'file_exist');
            $featureImageMobile = $featureImage = '';
            if (isset($pages->media_file) && !empty($pages->media_file)) {
                if (isset($arrFile['resize']) && !empty($arrFile['resize'])) {
                    $featureImage = url($arrFile['path'] . $arrFile['resize'] . 'x' . $arrFile['resize'] . '/' . $pages->media_file);
                    if (isset($pages->m_media_file) && !empty($pages->m_media_file)) {
                        $featureImageMobile = url($arrFile['path'] . $arrFile['resize'] . 'x' . $arrFile['resize'] . '/' . $pages->m_media_file);
                    } else {
                        $featureImageMobile = url($arrFile['path'] . $arrFile['resize'] . 'x' . $arrFile['resize'] . '/' . $pages->media_file);
                    }
                } else {
                    $featureImage = url($arrFile['path'] . '/' . $pages->media_file);
                    if (isset($pages->m_media_file) && !empty($pages->m_media_file)) {
                        $featureImageMobile = url($arrFile['path'] . '/' . $pages->m_media_file);
                    } else {
                        $featureImageMobile = url($arrFile['path'] . '/' . $pages->media_file);
                    }
                }
            }
            $dbRegion = new Region();
            $dynamicWhere = ' status = 1 AND deleted = 0 ';
            $orderby = '';
            $arrRegions = $dbRegion->getAll($orderby, $where = array(), $dynamicWhere);
        }

        if (!isset($pages) && empty($pages)) {
            $title = "404";
            $keywords = "Page not found";
            $description = "404 - Page not found";
            return response()->view('errors.404', compact('title', 'keywords', 'description'));
        }

        return view('cms', compact('arrRegions', 'pages', 'title', 'keywords', 'description', 'featureImage', 'featureImageMobile','pageName'));
    }

    public function ourPackages(Request $request)
    {
        $dbPackage = new Package();

        if (!empty(Session::get('city_id'))) {
            $dynamicWhere = 'package.status = 1 AND package_city.city_id =' . Session::get('city_id');
        } else {
            $dynamicWhere = 'package.status = 1';
        }
        //Added on 10th May 2020
        $dynamicWhere .= ' AND city_date_package.package_date >= "' . date("Y-m-d") . '"';

        $orderby = "package.order";
        $arrPackage = $dbPackage->getAllPackages($orderby, $where = array(), $dynamicWhere);

        $arrFile = array('name' => 'media_file', 'type' => 'file', 'resize' => '', 'path' => 'images/package/', 'predefine' => '', 'except' => 'file_exist', 'existing' => '');

        $title = 'Christmas 2019 | Our offerings';
        $keywords = '';
        $description = '';

        return view('ourpackages', compact('arrPackage', 'title', 'arrFile', 'keywords', 'description'));
    }

    public function packageDetails(Request $request, $packageName)
    {
        Session::put('development', false);
        if (isset($_REQUEST['development']) && !empty($_REQUEST['development'])) {
            Session::put('development', $_REQUEST['development']);
        }

        $dbPackage = new Package();

        $packageName = str_replace('-', ' ', $packageName);
        $packageData = $dbPackage->getOnePackage($packageName);
        $packageId = $packageData->id;

        if (!empty(Session::get('city_id'))) {
            $dynamicWhere = 'package.status = 1 AND package_city.city_id =' . Session::get('city_id');
        } else {
            $dynamicWhere = 'package.status = 1';
        }
        $orderby = "package.order";
        $arrPackageList = $dbPackage->getAllPackages($orderby, $where = array(), $dynamicWhere);

        $data = $request->input();
        $dbPackage = new Package();
        $orderby = "package.order";
        //$dynamicWhere = 'package.status = 1 AND package.id != '.$packageId;
        if (!empty(Session::get('city_id'))) {
            $dynamicWhere = 'package.status = 1 AND package.id != ' . $packageId . ' AND package_city.status = 1 AND package_city.city_id =' . Session::get('city_id');
        } else {
            $dynamicWhere = 'package.status = 1 AND package_city.status = 1 AND package.id != ' . $packageId;
        }
        $arrPackage = $dbPackage->getAllPackages($orderby, $where = array(), $dynamicWhere);

        if (!empty(Session::get('city_id'))) {
            $dynamicWhere = 'package.status = 1 AND package.id = ' . $packageId . ' AND city.id=' . Session::get('city_id');
        } else {
            $dynamicWhere = 'package.status = 1 AND package.id = ' . $packageId;
        }
        $arrPackageDate = $dbPackage->getPackageDateDetails($orderby, $where = array(), $dynamicWhere);

        if (!empty(Session::get('city_id'))) {
            $dynamicWhere = 'package_date >= "2020-01-15" AND package.status = 1 AND package.id = ' . $packageId . ' AND city.id=' . Session::get('city_id');
        } else {
            $dynamicWhere = 'package_date >= "2020-01-15" AND package.status = 1 AND package.id = ' . $packageId;
        }
        $objPackage = $dbPackage->retrivePackage($orderby = null, $where = array(), $dynamicWhere);

        $arrFile = array('name' => 'media_file', 'type' => 'file', 'resize' => '', 'path' => 'images/package/', 'predefine' => '', 'except' => 'file_exist', 'existing' => '');
        $title = 'Package Detail';
        $keywords = '';
        $description = '';

        $data = $request->input();
        $messages = [
            'firstName.required' => 'Please specify First Name',
        ];

        $regxvalidator = [
            'firstName' => 'required',
        ];
        $additopnalOperation = "";
        $arrExpect = array('name');
        $pageName = 'package-details/' . $packageId;

        if (!empty($data) && isset($data) && $request->isMethod('post')) {
            $dbRequestDemo = new RequestDemo();
            return Common::commanRequestPage($dbRequestDemo, $request, $messages, $regxvalidator, $arrFile, $additopnalOperation, $arrExpect, $pageName);
        }

        return view('packagedetails', compact('arrPackageList', 'arrPackage', 'title', 'arrFile', 'objPackage', 'title', 'keywords', 'description', 'arrPackageDate'));
    }

    function encrypt($plainText, $key)
    {
        $key = $this->hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        $encryptedText = bin2hex($openMode);
        return $encryptedText;
    }

    /*
    * @param1 : Encrypted String
    * @param2 : Working key provided by CCAvenue
    * @return : Plain String
    */
    function decrypt($encryptedText, $key)
    {
        $key = $this->hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $encryptedText = $this->hextobin($encryptedText);
        $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        return $decryptedText;
    }
    function hextobin($hexString)
    {
        $length = strlen($hexString);
        $binString = "";
        $count = 0;
        while ($count < $length) {
            $subString = substr($hexString, $count, 2);
            $packedString = pack("H*", $subString);
            if ($count == 0) {
                $binString = $packedString;
            } else {
                $binString .= $packedString;
            }

            $count += 2;
        }
        return $binString;
    }
   
    
    public function thankYou(Request $request)
    {
        $title = 'Thank You';
        $keywords = '';
        $description = '';
        return view('thank-you', compact('title', 'keywords', 'description'));
    }

    public function dataInsightsList(Request $request)
    {
        Common::getSettings();
        $dbPages = new Pages;
        $pages = $dbPages->where(['pages.deleted' => 0])->whereIn('type_id', [2])->whereIn('parent_id', [1])->paginate(3);

        //$getYearMonthList = $dbPages->where(['pages.deleted' => 0])->distinct("MONTH(created_at)")->get();
        //SELECT DISTINCT YEAR(created_at) FROM pages

        $title = "404";
        $keywords = "Page not found";
        $description = "404 - Page not found";
        if (!isset($pages) && empty($pages)) {
            return response()->view('errors.404', compact('title', 'keywords', 'description'));
        }
        if (isset($pages) && !empty($pages)) {
            $title = "Data Insights";
            $keywords = "Keywords goes here";
            $description = "Description goes here";
        }

        $dbRegion = new Region();
        $dynamicWhere = ' status = 1 AND deleted = 0 ';
        $orderby = '';
        $arrRegions = $dbRegion->getAll($orderby, $where = array(), $dynamicWhere);

        $data = $request->input();
        if (isset($data['year']) && !empty($data['year']) || isset($data['month']) && !empty($data['month']) || isset($data['region']) && !empty($data['region'])) {
            $pages = Pages::whereYear('created_at', '=', $data['year'])
                ->orWhere(function ($query) use ($data) {
                    $query->whereMonth('created_at', '=', $data['month']);
                })->orWhere(function ($query) use ($data) {
                    $query->where('region_id', '=', $data['region']);
                })->where(['pages.deleted' => 0])->whereIn('type_id', [2])->whereIn('parent_id', [1])->paginate(3);
        }

        return view('blog-list', compact('arrRegions', 'pages', 'title', 'keywords', 'description'));
    }
    public function whitePapers(Request $request)
    {
        Common::getSettings();
        $dbPages = new Pages;
        $pages = $dbPages->where(['pages.deleted' => 0])->whereIn('type_id', [2])->whereIn('parent_id', [2])->paginate(3);

        $title = "404";
        $keywords = "Page not found";
        $description = "404 - Page not found";
        if (!isset($pages) && empty($pages)) {
            return response()->view('errors.404', compact('title', 'keywords', 'description'));
        }
        if (isset($pages) && !empty($pages)) {
            $title = "Data Insights";
            $keywords = "Keywords goes here";
            $description = "Description goes here";
        }

        $dbRegion = new Region();
        $dynamicWhere = ' status = 1 AND deleted = 0 ';
        $orderby = '';
        $arrRegions = $dbRegion->getAll($orderby, $where = array(), $dynamicWhere);

        $data = $request->input();
        if (isset($data['year']) && !empty($data['year']) || isset($data['month']) && !empty($data['month']) || isset($data['region']) && !empty($data['region'])) {
            $pages = Pages::whereYear('created_at', '=', $data['year'])
                ->orWhere(function ($query) use ($data) {
                    $query->whereMonth('created_at', '=', $data['month']);
                })->orWhere(function ($query) use ($data) {
                    $query->where('region_id', '=', $data['region']);
                })->where(['pages.deleted' => 0])->whereIn('type_id', [2])->whereIn('parent_id', [1])->paginate(3);
        }

        return view('blog-list', compact('arrRegions', 'pages', 'title', 'keywords', 'description'));
    }
    public function commonRequest(Request $request)
    {
        $messages = [
            'firstName.required' => 'Please specify First Name',
            'lastName.required' => 'Please specify Last Name',
            'email.required' => 'Please specify Email',
            'tel.required' => 'Please specify Phone Number',
        ];

        $regxvalidator = [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required',
            'tel' => 'required',
        ];
        $additopnalOperation = "";
        $arrExpect = array('name');
        $pageName = "";
        $arrFile = "";

        if ($request->isMethod('post')) {
            $dbRequestDemo = new RequestDemo();
            return Common::commanRequestPage($dbRequestDemo, $request, $messages, $regxvalidator, $arrFile, $additopnalOperation, $arrExpect, $pageName);
        }
    }
    public function contact(Request $request)
    {
        $dbContactUs = new ContactUs();

        $messages = [
            'name.required' => 'Please specify Name',
            'email.required' => 'Please specify Email',
            'tel.required' => 'Please specify Phone Number',
        ];
        $regxvalidator = [
            'name' => 'required',
            'email' => 'required',
            'tel' => 'required',
        ];
        $additopnalOperation = "";
        $arrExpect = array('');
        $pageName = "";
        $arrFile = "";

        $userName = $request->name;
        $registerEmailId = 2;
        Session::put('firstName',$userName);
        Session::put('registerEmailId',$registerEmailId);

        $captcha = $_POST['g-recaptcha-response'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $key = '6LdITRAhAAAAAKpaIfYlsLL0rdeGp4_E3YRZbPhk';
        $url = 'https://www.google.com/recaptcha/api/siteverify';

        $recaptcha_response = file_get_contents($url . '?secret=' . $key . '&response=' . $captcha . '&remoteip=' . $ip);
        $data = json_decode($recaptcha_response);

        if (isset($data->success) &&  $data->success === true) {
            $email = $request->email;
            Mail::send('email_template', [], function ($message) use ($email) {
                $message->to($email)
                    ->subject('Thank you for Contacting Us.')
                    ->from(env('FROM_EMAIL'), env('FROM_SUBJECT'));
            });
            return Common::commanRequestPage($dbContactUs, $request, $messages, $regxvalidator, $arrFile, $additopnalOperation, $arrExpect, $pageName);
            
        } else {
            Session::flash('message', 'Your account has been logged as a spammer, you cannot continue!');
            Session::flash('alert-class', 'alert-danger');
            return redirect('contact');
        }
    }

    public function dataSolutionsList(Request $request)
    {
        Common::getSettings();
        $dbPackage = new Package();
        $pages = $dbPackage->where(['package.deleted' => 0])->whereIn('category', [3])->paginate(3);

        $title = "404";
        $keywords = "Page not found";
        $description = "404 - Page not found";
        if (!isset($pages) && empty($pages)) {
            return response()->view('errors.404', compact('title', 'keywords', 'description'));
        }
        if (isset($pages) && !empty($pages)) {
            $title = "Data Solutions";
            $keywords = "Keywords goes here";
            $description = "Description goes here";
        }

        $dbRegion = new Region();
        $dynamicWhere = ' status = 1 AND deleted = 0 ';
        $orderby = '';
        $arrRegions = $dbRegion->getAll($orderby, $where = array(), $dynamicWhere);

        return view('data-solutions', compact('arrRegions', 'pages', 'title', 'keywords', 'description'));
    }

    public function signUp(Request $request)
    {
        Common::getSettings();
        $dbPages = new Pages;
        $pages = $dbPages->where(['pages.deleted' => 0, 'alias' => 'contact'])->whereNotIn('type_id', [4])->get();

        $title = "404";
        $keywords = "Page not found";
        $description = "404 - Page not found";
        if (!isset($pages) && empty($pages)) {
            return response()->view('errors.404', compact('title', 'keywords', 'description'));
        }
        if (isset($pages) && !empty($pages)) {
            $title = "Data Solutions";
            $keywords = "Keywords goes here";
            $description = "Description goes here";
        }

        $dbRegion = new Region();
        $dynamicWhere = ' status = 1 AND deleted = 0 ';
        $orderby = '';
        $arrRegions = $dbRegion->getAll($orderby, $where = array(), $dynamicWhere);
        $messages = [
            'first_name.required' => 'Please specify First Name',
            'last_name.required' => 'Please specify Last Name',
            'email.required' => 'Please specify Email',
            'company.required' => 'Please specify Company Name',
            'country.required' => 'Please specify Country Name',
            'address1.required' => 'Please specify Address',
            'city.required' => 'Please specify City Name',
            'phone_number.required' => 'Please specify Phone Number',
            'password' => 'Please specify Password',
        ];
        $regxvalidator = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'company' => 'required',
            'country' => 'required',
            'address1' => 'required',
            'city' => 'required',
            'phone_number' => 'required',
            'password' => 'required',
        ];

        $additopnalOperation = "";
        $arrExpect = array('g-recaptcha-response');
        $pageName = "";
        $arrFile = "";
        if ($request->isMethod('post')) {
            $data = $request->input();
            $dbEmailTemplates = new EmailTemplates;
            $emialTemplates = $dbEmailTemplates->where(['deleted' => 0, 'slug' => 'thank-you'])->first();
            $emailData = [
                'siteURL' => url('/'),
                'VisitorName' => $data['first_name'],
            ];

            $userName = $request->first_name;
            $registerEmailId = 1;
            Session::put('firstName',$userName);
            Session::put('registerEmailId',$registerEmailId);
            $email = $request->email;                               
            $parsed = $emialTemplates->parse($emailData);
            Mail::send('email_template', [], function ($message) use ($emialTemplates, $data, $parsed,$email) {
                $message->to($email)
                    ->subject('Thank you for Register.')
                    ->from(env('FROM_EMAIL'), env('FROM_SUBJECT'));
            });

            $captcha = $_POST['g-recaptcha-response'];
            $ip = $_SERVER['REMOTE_ADDR'];
            $key = env('GOOGLE_SECRET_KEY');
            $url = 'https://www.google.com/recaptcha/api/siteverify';

            $recaptcha_response = file_get_contents($url . '?secret=' . $key . '&response=' . $captcha . '&remoteip=' . $ip);
            $data = json_decode($recaptcha_response);

            if (isset($data->success) &&  $data->success === true) {
                $request['password'] = bcrypt($request->password);
                $request['role_id'] = 6;
                $request['name'] = $request->first_name;
                $dbRegister = new Users();
                return Common::commanRegister($dbRegister, $request, $messages, $regxvalidator, $arrFile, $additopnalOperation, $arrExpect, $pageName);
            } else {
                Session::flash('message', 'Your account has been logged as a spammer, you cannot continue!');
                Session::flash('alert-class', 'alert-danger');
                return redirect('log-in');
            }
        }

        return view('sign-up', compact('arrRegions', 'pages', 'title', 'keywords', 'description'));
    }

    public function logIn(Request $request)
    {
        Common::getSettings();
        $Setting = new Setting();

        if ($request->isMethod('post')) {
            $captcha = $_POST['g-recaptcha-response'];
            $ip = $_SERVER['REMOTE_ADDR'];
            $key =  env('GOOGLE_SECRET_KEY');
            $url = 'https://www.google.com/recaptcha/api/siteverify';

            $recaptcha_response = file_get_contents($url . '?secret=' . $key . '&response=' . $captcha . '&remoteip=' . $ip);
            $data = json_decode($recaptcha_response);

            if (isset($data->success) &&  $data->success === true) {
                $credentials = [
                    'email' => $request->email,
                    'password' => trim($request->password)
                ];
                $userDetails = Users::where('email', $request->email)->where('role_id', 6)->first();
                if (isset($userDetails) && !empty($userDetails)) {
                    if (auth()->attempt($credentials)) {
                        $arrSettings = $Setting->getSettingByName('ALLOWED_IP');
                        $arrSettingscheck = $Setting->getSettingByName('ALLOWED_IP_ENABLE');

                        if ($arrSettingscheck['value'] != '1' || ($arrSettingscheck['value'] == '1' && isset($arrSettings['name']) && !empty($arrSettings['name']) && in_array($request->ip(), explode(",", $arrSettings['value'])))) {
                            Session::put('email', $userDetails['email']);
                            Session::put('id', $userDetails->id);
                            Session::put('role', $userDetails->role_id);
                            Session::put('firstname', $userDetails->firstName);
                            Session::put('lastname', $userDetails->lastName);
                            Session::put('name', $userDetails->name);
                        }
                        //$backURL = Session::get('backUrl');
                        return redirect('/');
                    } else {
                        Session::flash('message', 'Please Enter correct email and password');
                        Session::flash('alert-class', 'alert-danger');
                        return redirect('log-in');
                    }
                } else {
                    Session::flash('message', 'Please Enter correct email and password');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect('log-in');
                }
            } else {
                Session::flash('message', 'Your account has been logged as a spammer, you cannot continue!');
                Session::flash('alert-class', 'alert-danger');
                return redirect('log-in');
            }
        }
    }

    public function showFormLogin()
    {
        $user = Auth::User();
        if (isset($user) && !empty($user)) {
            //redirect on my orders
        }
        $dbPages = new Pages;
        $pages = $dbPages->where(['pages.deleted' => 0, 'alias' => 'contact'])->whereNotIn('type_id', [4])->get();

        $title = "404";
        $keywords = "Page not found";
        $description = "404 - Page not found";
        if (!isset($pages) && empty($pages)) {
            return response()->view('errors.404', compact('title', 'keywords', 'description'));
        }
        $dbRegion = new Region();
        $dynamicWhere = ' status = 1 AND deleted = 0 ';
        $orderby = '';
        $arrRegions = $dbRegion->getAll($orderby, $where = array(), $dynamicWhere);

        return view('log-in', compact('arrRegions', 'pages', 'title', 'keywords', 'description'));
    }

    public function forgotPass(Request $request)
    {
        Common::getSettings();
        $dbPages = new Pages;
        $pages = $dbPages->where(['pages.deleted' => 0, 'alias' => 'contact'])->whereNotIn('type_id', [4])->get();

        $title = "404";
        $keywords = "Page not found";
        $description = "404 - Page not found";
        if (!isset($pages) && empty($pages)) {
            return response()->view('errors.404', compact('title', 'keywords', 'description'));
        }
        if (isset($pages) && !empty($pages)) {
            $title = "Forgot Password";
            $keywords = "Keywords goes here";
            $description = "Description goes here";
        }

        $dbRegion = new Region();
        $dynamicWhere = ' status = 1 AND deleted = 0 ';
        $orderby = '';
        $arrRegions = $dbRegion->getAll($orderby, $where = array(), $dynamicWhere);
        $messages = [
            'email.required' => 'Please specify Email',
        ];
        $regxvalidator = [
            'email' => 'required',
        ];

        if ($request->isMethod('post')) {
            if($request->input('forgotId') == 1 && !empty($request->input('forgotId')))
            {
                $forgotUserId = $request->forgotUserId;
                $password = bcrypt($request->password);
                DB::table('users')->where(['id' => $forgotUserId])->update(['password' => $password]);
            }
            else{
                $email = $request->input('email');
                $dbUsers = new Users;
                $userObj = $dbUsers->where(['users.deleted' => 0, 'users.email' => $email, 'role_id' => 6])->first();
                if(!empty($userObj->id))
                {
                    $email = $userObj->email;
                    $userId = $userObj->id;
                    echo $email.'/'.$userId;
                    die();
                }
                else{
                    Session::flash('message', 'You are not registered on the it Fuel Trend yet');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect('forgot');
                }
            }
        }

        return view('forgot', compact('arrRegions', 'pages', 'title', 'keywords', 'description'));
    }

    public function customReports(Request $request)
    {
        $dbTerminal = new Terminal();

        if (!empty($request->isMethod('post'))) {

            $packageId =  Session::get('package_id');
            
            $dbPackage = new Package();
            $package_data = $dbPackage->where(['package.deleted' => 0, 'package.id' => $packageId])->first();            

            $reportTitles = json_decode($package_data['report_title'], true);
            $reportPrices = json_decode($package_data['report_prices'], true);

            foreach ($reportTitles as $key => $value) {
                $reportTitle[] = $value;
            }
            foreach ($reportPrices as $key => $val) {
                $reportPrice[] = $val;
            }   
            
            if (!empty($request->input('case'))) {
                $requestData = $request->input('case');

                $terminal = $dbTerminal->where(['terminal.deleted' => 0])->get();
                foreach ($terminal as $key => $value) {
                    if (in_array($value->id, $requestData)) {
                        $terminal_data[] = $dbTerminal->where(['terminal.deleted' => 0, 'terminal.id' => $value->id])->paginate(10);
                    }
                }

                Session::put('customReportData', $requestData);
                $title = 'Custom trends';
                $keywords = '';
                $description = '';
                return view('custom-trends', compact('title', 'keywords', 'description', 'terminal_data', 'reportTitle', 'reportPrice'));
            } else {
                if (!empty($request->input('zip_code'))) {
                    $zip_code = $request->input('zip_code');
                    $terminal = $dbTerminal->where(['terminal.deleted' => 0, 'terminal.zip_code' => $zip_code])->paginate(10);

                    $title = 'Custom trends';
                    $keywords = '';
                    $description = '';
                    return view('custom-reports', compact('title', 'keywords', 'description', 'terminal'));
                } else {
                    $terminal = $dbTerminal->where(['terminal.deleted' => 0])->paginate(10);
                    $title = 'Custom Reports';
                    $keywords = '';
                    $description = '';
                    return view('custom-reports', compact('title', 'keywords', 'description', 'terminal'));
                }
            }
        } else {
            $terminal = $dbTerminal->where(['terminal.deleted' => 0])->paginate(10);
            $title = 'Custom Reports';
            $keywords = '';
            $description = '';
            return view('custom-reports', compact('title', 'keywords', 'description', 'terminal'));
        }
    }

    public function customTrends(Request $request)
    {
        $dbReports = new Reports();
        $dbCustomReports = new CustomReports();

        if ($request->isMethod('post')) {
            $data = $request->input();
            $customReportData = Session::get('customReportData');

            if (isset($request->created_by) && !empty($request->created_by)) {
                $request->merge(["created_by" => $request->created_by, 'created_at' => date("Y-m-d H:i:s"), 'updated_by' => Session::get('id')]);
            } else {
                $request->merge(["created_by" => Session::get('id'), 'created_at' => date("Y-m-d H:i:s"), 'updated_by' => Session::get('id')]);
            }
            Session::put('cart_id', $request->cart_id);
            $packageId             =  Session::get('package_id');
            $request['package_id'] = $packageId;
            $dbReports->insert($request->except(array_merge(['_token'])));

            $cartId = $request->cart_id;

            foreach ($customReportData as $key => $value) {
                $customReportId[] = new CustomReports(['custom_checkbox' => $value, 'title' => $request['report_title'], 'user_id' => $request['user_id'], 'cart_id' => $cartId]);
            }
            $dbReports->CustomReports()->saveMany($customReportId);

            return redirect('cart');
        }
        $title = 'Custom trends';
        $keywords = '';
        $description = '';
        return view('custom-trends', compact('title', 'keywords', 'description'));
    }
    public function cart(Request $request)
    {
        $dbReports = new Reports();

        if (!empty($request->input())) {
            $reportId = $request->input('getTrId');
            $update = array(
                'deleted' => 1,
                'deleted_by' => Session::get('id'),
            );
            if ($reportId == 1) {
                $data = $dbReports->deleteCart(Session::get('id'), $update);
            } else {
                $dbReports->deleteOne($reportId, $update);
            }
        }

        $cart_id = Session::get('cart_id');
        $user_id = Session::get('id');
        $cartData = $dbReports->where(['reports.deleted' => 0, 'user_id' => $user_id])->get();

        $title = 'Cart';
        $keywords = '';
        $description = '';
        return view('cart', compact('title', 'keywords', 'description', 'cartData', 'cart_id'));
    }
    public function checkout(Request $request)
    {
        Session::put('totalPrice', $request->input('totalPrice'));

        $dbUsers = new Users();
        $cart_id = Session::get('cart_id');
        $user_id = Session::get('id');
        $usersData = $dbUsers->where(['users.deleted' => 0, 'id' => $user_id])->first();

        $title = 'Checkout';
        $keywords = '';
        $description = '';
        return view('checkout', compact('title', 'keywords', 'description', 'usersData'));
    }
    public function reviewAndPay(Request $request)
    {
        $dbUsers = new Users();
        $UserObj = $dbUsers->where(['users.deleted' => 0, 'users.email' => Session::get('email')])->first();
        $StripeInstance = new StripeHelper();

        $CustomerData['email'] = Session::get('email');
        $CustomerData['name'] = Session::get('firstname');

        if (is_null($UserObj['stripe_id']) || $UserObj['stripe_id'] == 'NULL') {
            $StripeCustomer = $StripeInstance->CreateCustomer($CustomerData);
            $UserObj->stripe_id = $StripeCustomer->id;
            $UserObj->save();
        } else if (!is_null($UserObj['stripe_id']) || $UserObj['stripe_id'] != 'NULL') {
            $StripeCustomer = $StripeInstance->getStripeCustomer($UserObj['stripe_id']);
        }

        $totalPrice = str_replace('$', '', Session::get('totalPrice'));
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        $intent = $stripe->paymentIntents->create(
            [
                'amount' => $totalPrice * 1,
                'currency' => 'usd',
                'automatic_payment_methods' => ['enabled' => true],
            ]
        );
        
        if ($request->isMethod('post')) {
            $billingdata = $request->input();
        }

        $title = 'Review & Pay';
        $keywords = '';
        $description = '';
        return view('review-and-pay', compact('title', 'keywords', 'description', 'billingdata', 'UserObj', 'intent'));
    }

    public function logOut(Request $request)
    {
        Session::forget('email');
        $redirectTo = Session::get('backUrl');
        Auth::logout();
        return redirect($redirectTo);
    }

    public function newsAndUpdateList(Request $request)
    {
        Common::getSettings();
        $search = $request->input('search');
        $dbNews = new News;
        if(isset($search) && !empty($search)){
            $pages = $dbNews->where('news.deleted', 0)->where('news.title','like','%'.$search.'%')->orWhere('news.content','like','%'.$search.'%')->paginate(3);
        }else{
            $pages = $dbNews->where(['news.deleted' => 0])->paginate(3);
        }

        $title = "404";
        $keywords = "Page not found";
        $description = "404 - Page not found";
        if (!isset($pages) && empty($pages)) {
            return response()->view('errors.404', compact('title', 'keywords', 'description'));
        }
        if (isset($pages) && !empty($pages)) {
            $title = "News And Update";
            $keywords = "Keywords goes here";
            $description = "Description goes here";
        }

        $dbRegion = new Region();
        $dynamicWhere = ' status = 1 AND deleted = 0 ';
        $orderby = '';
        $arrRegions = $dbRegion->getAll($orderby, $where = array(), $dynamicWhere);
        $newsAndUpadte = 1;

        $data = $request->input();
        if (isset($data['year']) && !empty($data['year']) || isset($data['month']) && !empty($data['month']) || isset($data['region']) && !empty($data['region'])) {
            $pages = News::whereYear('created_at', '=', $data['year'])
                ->orWhere(function ($query) use ($data) {
                    $query->whereMonth('created_at', '=', $data['month']);
                })->where(['news.deleted' => 0])->paginate(3);
        }
        elseif((isset($data['search']) && !empty($data['search'])))
        {
            $pages = News::where(function ($query) use ($data) {
                    $query->where('title', 'like', '%'.$data['search'].'%');
                })->where(['news.deleted' => 0])->paginate(3);
        }
        return view('blog-list', compact('arrRegions', 'pages', 'title', 'keywords', 'description', 'newsAndUpadte'));
    }

    public function industriesList(Request $request)
    {
        Common::getSettings();
        $dbIndustries = new Industries;
        $pages = $dbIndustries->where(['industries.deleted' => 0])->paginate(3);

        $title = "404";
        $keywords = "Page not found";
        $description = "404 - Page not found";
        if (!isset($pages) && empty($pages)) {
            return response()->view('errors.404', compact('title', 'keywords', 'description'));
        }
        if (isset($pages) && !empty($pages)) {
            $title = "Data Insights";
            $keywords = "Keywords goes here";
            $description = "Description goes here";
        }

        $dbRegion = new Region();
        $dynamicWhere = ' status = 1 AND deleted = 0 ';
        $orderby = '';
        $arrRegions = $dbRegion->getAll($orderby, $where = array(), $dynamicWhere);
        $industries = 2;

        $data = $request->input();
        if (isset($data['year']) && !empty($data['year']) || isset($data['month']) && !empty($data['month']) || isset($data['region']) && !empty($data['region'])) {
            $pages = News::whereYear('created_at', '=', $data['year'])
                ->orWhere(function ($query) use ($data) {
                    $query->whereMonth('created_at', '=', $data['month']);
                })->orWhere(function ($query) use ($data) {
                    $query->where('region_id', '=', $data['region']);
                })->where(['news.deleted' => 0])->whereIn('type_id', [2])->whereIn('parent_id', [1])->paginate(3);
        }

        return view('blog-list', compact('arrRegions', 'pages', 'title', 'keywords', 'description', 'industries'));
    }

    public function payment(Request $request)
    {   
        $cartId = $request->input('cartId');

        if(!empty($cartId)) {
            $dbReports  = new Reports();
            $dbBooking  = new Booking();
            $reportData = $dbReports->where(['reports.deleted' => 0, 'reports.cart_id' => $cartId])->first();

            $reportInsert['user_id']        = $reportData['user_id'];
            $reportInsert['cart_id']        = $reportData['cart_id'];
            $reportInsert['report_title']   = $reportData['report_title'];
            $reportInsert['price']          = $reportData['price_id'];
            $reportInsert['booking_date']   = date("Y-m-d");
            $reportInsert['created_at']     = date("Y-m-d H:i:s");
            $reportInsert['status']         = 0;
            $dbBooking->insert($reportInsert);
        }
    }

    public function faqList(Request $request)
    {
        $dbFaq = new Faq;
        $faq = $dbFaq->where(['faq.deleted' => 0])->paginate(3);
        // echo'<pre>';print_r($faq);die;

        $title = "404";
        $keywords = "Page not found";
        $description = "404 - Page not found";
        if (!isset($faq) && empty($faq)) {
            return response()->view('errors.404', compact('title', 'keywords', 'description'));
        }
        if (isset($faq) && !empty($faq)) {
            $title = "";
            $keywords = "Keywords goes here";
            $description = "Description goes here";
        }

        $dbRegion = new Region();
        $dynamicWhere = ' status = 1 AND deleted = 0 ';
        $orderby = '';
        $arrRegions = $dbRegion->getAll($orderby, $where = array(), $dynamicWhere);

        return view('faq', compact('arrRegions', 'faq', 'title', 'keywords', 'description'));
    }
}
