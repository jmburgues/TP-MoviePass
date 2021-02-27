<?php namespace Config;

/* PATH CONSTANTS */

define("ROOT", dirname(__DIR__) . "/"); 
define("FRONT_ROOT", "/");
define("VIEWS_PATH", ROOT."Views/");
define("CSS_PATH", FRONT_ROOT.VIEWS_PATH . "css/");
define("JS_PATH", FRONT_ROOT.VIEWS_PATH . "js/");

define('CONFIG',ROOT.'Config');

define('IMG_PATH', FRONT_ROOT . "Views/img/");

// SMTP 
define('MAIL_USR','themoviepassteamutn'); 
define('MAIL_DOMAIN','gmail.com'); 
define('MAIL_PASS','mardelplata22');
define("MAIL_SERVER","smtp.gmail.com");

// MovieDB API
define('API_KEY','783ce81a4a4455d3719eb5ca1f039861'); 
define('API_IMAGE_URL','https://image.tmdb.org/t/p/');

define('POSTER_WIDTH_92', "w92/");
define('POSTER_WIDTH_154', "w154/");
define('POSTER_WIDTH_185', "w185/");
define('POSTER_WIDTH_342', "w342/");
define('POSTER_WIDTH_500', "w500/");
define('POSTER_WIDTH_780', "w780/");
define('POSTER_WIDTH_ORIGINAL', "original/");

/* DATABASE CONSTANTS */

//REMOTE DATABASE 
 
define("DB_HOST", "bnjcqyikcuwpbcrt6swg-mysql.services.clever-cloud.com");
define("DB_NAME", "bnjcqyikcuwpbcrt6swg");
define("DB_USER", "udtersuq8vbpzdhd");
define("DB_PASS", "ChwYSan0mf7eZdblMfBV");

// LOCALHOST

// define("DB_HOST", "127.0.0.1");
// define("DB_NAME", "MOVIEPASSDB");
// define("DB_USER", "root");
// define("DB_PASS", "");

// IMAGES STORAGE
//
define("IMG_BLACKBG","https://lh3.googleusercontent.com/fife/ABSRlIqAgf4zBkC2Epr9aAUsHQp_mmdLsdqhLsYKNqiOufzsMsatoZxf3g1ACzeKs6NUlbSCwosQaCjH5EAHtftkso-AW3-ShTrC4_6LeJPNOdlESXw7TVTk-aPF3OyyJKkF-Xwb7l1PlgCdQRYxRf8sszOO_lMzw60bDAy_zvGvyslJ9iIQ9GBjdHM1dVbukQVE9LC4lnSfEXI6exywTGFlj3xf_PSNLLUJkXKIgrXcdFnVpMVU7KS9iqUfa1_sHD_WQ2wqsmOD29sMsO6ofZS83ORuS41i9kYKPm6xcd06YSfm_yERyFXE8gfasHi2bsEGaJwcQLeOVjcExWXD0yiEj-nTjcJ-pLQsuqfa7fWwaLFm_2IHoNdcHVLkAgA9YIvi3rTwGSLioZWp1wZdOhqz1VcHkSbIid7jTQA2e6Qp8V1yS9qxAaiwTPXFLK9hpbOJUnX7YqwV-vomBwDQ3tqikrlH8EGUswWXm45rhihMTTE7BvSV3QhE7qhKkeu9ct1tjdV1D83zGIQcdWHP8v7yXEQ0snntUg5yElIVIdpxLfHXYZwJqfAVd0VHSaUUIwsjbx8b_a30IljRDp7uPyjna3Sx5CCtI3KCm0P15gow7szP27kCyMoL826bWqB1jRZ2KP5hQU8sTRthkY-SzWCqfAf5ggKca5f0q8PKC_Eb3J1Zr92NJUo6zAmvccfWWNi4HpyGPN3jQn0BMgc3T_AkPmdnKS0lRBOb--o=w1366-h251-ft");
define("IMG_NOTFOUND","https://drive.google.com/viewerng/img?id=https://lh3.googleusercontent.com/fife/ABSRlIom_tauIPurqMJslW3HM6didihZu7v40R7dJ0eVXv8rr2QBgLn6nOnnsRda75n-GDvD0s94fcXO1eXQV-3PrjKRIlmbTLg1TyPlgNJG9BAG_9G_LcOlQ6ON21n4_haPoIJCa9bFpV7QgHceEZeY7ODULQLZJ42arjoBeem7UKFpoORSlzuL7fEH9v73rwfYEDU8OXPxFDed7Sw5pVpnsN0ir2TvrQOZBuOexeOjjJ1zieboX35uz0i9JItux6Nu_sTgvoc2EO55PeT0icNcn9Jg0cq6_fcM3molzTUDHokbIpnY5f08cjph8T8jxHZM9L9mOpr7FE8nR5l2ec1ARK4P5n3j8OgWMZvwwfbQaRlYZsqLH6UOkBtV5oP5SaT8hlXXT8sC64ZTFORegpSjcDhfJRWi8shp1rqNr-UGR3tidfH2eDhaNHzSqqzjIdzjRYD_e90pUhN4yxb_CL0O8VwW48igJY65s0LH3ptmeSgu57icYaTfF4zu54BWm9lj1iN94x-2Amldg2psiEJ4HsVH5intynEBmMIWCaHXXISIM8QYy71tEFvtdZFF4gWYtCexBKLGJSJBynOd1iMZLxIUApmIbneFgPkvOjGRp6MRDjEsVUjRijBOfWbqKm9XMNtwlHEP5gUtO4cjnnOao3939DyP0-NTOCDVlHDa3CSVCVyFwXeRT6db2evRZs4h5G_gCPTFojoxYVZhBRQAvDsYCT7rQFc-Wcw=w800-ft");
define("IMG_CARDNOTFOUND","example.com");
define("IMG_NOMOVIEIMG","https://lh3.googleusercontent.com/fife/ABSRlIom_tauIPurqMJslW3HM6didihZu7v40R7dJ0eVXv8rr2QBgLn6nOnnsRda75n-GDvD0s94fcXO1eXQV-3PrjKRIlmbTLg1TyPlgNJG9BAG_9G_LcOlQ6ON21n4_haPoIJCa9bFpV7QgHceEZeY7ODULQLZJ42arjoBeem7UKFpoORSlzuL7fEH9v73rwfYEDU8OXPxFDed7Sw5pVpnsN0ir2TvrQOZBuOexeOjjJ1zieboX35uz0i9JItux6Nu_sTgvoc2EO55PeT0icNcn9Jg0cq6_fcM3molzTUDHokbIpnY5f08cjph8T8jxHZM9L9mOpr7FE8nR5l2ec1ARK4P5n3j8OgWMZvwwfbQaRlYZsqLH6UOkBtV5oP5SaT8hlXXT8sC64ZTFORegpSjcDhfJRWi8shp1rqNr-UGR3tidfH2eDhaNHzSqqzjIdzjRYD_e90pUhN4yxb_CL0O8VwW48igJY65s0LH3ptmeSgu57icYaTfF4zu54BWm9lj1iN94x-2Amldg2psiEJ4HsVH5intynEBmMIWCaHXXISIM8QYy71tEFvtdZFF4gWYtCexBKLGJSJBynOd1iMZLxIUApmIbneFgPkvOjGRp6MRDjEsVUjRijBOfWbqKm9XMNtwlHEP5gUtO4cjnnOao3939DyP0-NTOCDVlHDa3CSVCVyFwXeRT6db2evRZs4h5G_gCPTFojoxYVZhBRQAvDsYCT7rQFc-Wcw=w800-ft");
define("IMG_ICONLOGO","ttps://lh3.googleusercontent.com/u/0/d/1vVr75XnwbS4cd1avWt6JvznVB31CIX0p=w1366-h345-iv1");
define("IMG_NAVBCKG","https://lh3.googleusercontent.com/u/0/d/1Y0TFXPwOWvFtu8HH1gVqx_DRt569pxPc=w1366-h355-iv1");
define("IMG_VISA","https://lh3.googleusercontent.com/u/0/d/1bvBFH9zTyM4kYTnQOJhBdNZQ5juPrXJr=w1366-h355-iv1");
define("IMG_MASTER","https://lh3.googleusercontent.com/u/0/d/16sDLKaxkRzx-g9hZCdy5JgAVG4SKYmIB=w800-iv1");
define("IMG_AMERICAN","https://lh3.googleusercontent.com/u/0/d/1mbhjy0l0lPxLWjVcJ2oHN0LCSp5KoAEk=w800-iv1");
?>

