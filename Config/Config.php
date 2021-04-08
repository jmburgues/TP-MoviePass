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
define('MAIL_USR','moviepassutnbriascomontenegro'); 
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

// LOCALHOST

// define("DB_HOST", "127.0.0.1");
// define("DB_NAME", "MOVIEPASSDB");
// define("DB_USER", "root");
// define("DB_PASS", "");


// IMAGES STORAGE
    // backgrounds
    define("IMG_BLACKBG","https://lh3.googleusercontent.com/fife/ABSRlIqAgf4zBkC2Epr9aAUsHQp_mmdLsdqhLsYKNqiOufzsMsatoZxf3g1ACzeKs6NUlbSCwosQaCjH5EAHtftkso-AW3-ShTrC4_6LeJPNOdlESXw7TVTk-aPF3OyyJKkF-Xwb7l1PlgCdQRYxRf8sszOO_lMzw60bDAy_zvGvyslJ9iIQ9GBjdHM1dVbukQVE9LC4lnSfEXI6exywTGFlj3xf_PSNLLUJkXKIgrXcdFnVpMVU7KS9iqUfa1_sHD_WQ2wqsmOD29sMsO6ofZS83ORuS41i9kYKPm6xcd06YSfm_yERyFXE8gfasHi2bsEGaJwcQLeOVjcExWXD0yiEj-nTjcJ-pLQsuqfa7fWwaLFm_2IHoNdcHVLkAgA9YIvi3rTwGSLioZWp1wZdOhqz1VcHkSbIid7jTQA2e6Qp8V1yS9qxAaiwTPXFLK9hpbOJUnX7YqwV-vomBwDQ3tqikrlH8EGUswWXm45rhihMTTE7BvSV3QhE7qhKkeu9ct1tjdV1D83zGIQcdWHP8v7yXEQ0snntUg5yElIVIdpxLfHXYZwJqfAVd0VHSaUUIwsjbx8b_a30IljRDp7uPyjna3Sx5CCtI3KCm0P15gow7szP27kCyMoL826bWqB1jRZ2KP5hQU8sTRthkY-SzWCqfAf5ggKca5f0q8PKC_Eb3J1Zr92NJUo6zAmvccfWWNi4HpyGPN3jQn0BMgc3T_AkPmdnKS0lRBOb--o=w1366-h251-ft");
    define("IMG_NOBG","https://lh3.googleusercontent.com/fife/ABSRlIpbsV4AaUQ7jUBD2WU4JXtsCOTc8YAAxMtqb7L18ukO3rq4ISjL_ihlAmxAeUvk2mOabDKw5fb8NCYSaL1Lzxh0s3tmwxLXr8zf7Xktt5pd35BQwyuSKa1at5tL3TSXb8amxKdnIVpXJdRQWCAbaXR3QMNuUbJjxwEicc7DXC0oxXZ4Uad0_DeZLvN3Ljzro2UpTedMawrRISvdpEeA2wynxEYQ0hqTlNk9M1u-0LCmyh92968xCwgOrv1we1acUNHsVGv_WomjxBGs1Rl_HJqQxlGWoIwufI7yXlNMFBBoEdeAzUke9-vQ7UnoHCByXwoZQmBmyN7-OFCP-hmF2jbSI7Ac0wvmjk0UmmOPkJpD0nEv2kjoK9oheQcN70MfY_JufHx_YFnLBPFp8F3AzNAI0fuVOjZMoNuRGCA0WEwK5EQLzQGAT8mfXjMM2RwLiQ5M0e2XUWj3_UXQBRnkLmA8TB6EaYS_fjwZQueYcCE-NLB-MiB8Lr2PdGtcKSVFAHUK-AkL0o4WJFJ8o4bwsJzQLypmFDBX3JRm1-wQR7zTb0c6dDWqD-7mTV2ONYt8wW0gg9uiaOA4EgQt7PfqqRner8nVn3xqENjXwyjp-_OoWhPzRVoc4BHGID9LbipHU0zKKUaLJZZmDuJmKUzq4uljV00JsHaefFs-J1ncEfgw_ywxUjvR2IkSv7Dc9FFqNUiHi7dKHRjE4zk2_PPasoxEDkKYRSFV2UQ=w1366-h251-ft");
    define("IMG_NAVBCKG","https://lh3.googleusercontent.com/u/0/d/1Y0TFXPwOWvFtu8HH1gVqx_DRt569pxPc=w1366-h355-iv1");
        // others
    define("IMG_NOTFOUND","https://drive.google.com/viewerng/img?id=https://lh3.googleusercontent.com/fife/ABSRlIom_tauIPurqMJslW3HM6didihZu7v40R7dJ0eVXv8rr2QBgLn6nOnnsRda75n-GDvD0s94fcXO1eXQV-3PrjKRIlmbTLg1TyPlgNJG9BAG_9G_LcOlQ6ON21n4_haPoIJCa9bFpV7QgHceEZeY7ODULQLZJ42arjoBeem7UKFpoORSlzuL7fEH9v73rwfYEDU8OXPxFDed7Sw5pVpnsN0ir2TvrQOZBuOexeOjjJ1zieboX35uz0i9JItux6Nu_sTgvoc2EO55PeT0icNcn9Jg0cq6_fcM3molzTUDHokbIpnY5f08cjph8T8jxHZM9L9mOpr7FE8nR5l2ec1ARK4P5n3j8OgWMZvwwfbQaRlYZsqLH6UOkBtV5oP5SaT8hlXXT8sC64ZTFORegpSjcDhfJRWi8shp1rqNr-UGR3tidfH2eDhaNHzSqqzjIdzjRYD_e90pUhN4yxb_CL0O8VwW48igJY65s0LH3ptmeSgu57icYaTfF4zu54BWm9lj1iN94x-2Amldg2psiEJ4HsVH5intynEBmMIWCaHXXISIM8QYy71tEFvtdZFF4gWYtCexBKLGJSJBynOd1iMZLxIUApmIbneFgPkvOjGRp6MRDjEsVUjRijBOfWbqKm9XMNtwlHEP5gUtO4cjnnOao3939DyP0-NTOCDVlHDa3CSVCVyFwXeRT6db2evRZs4h5G_gCPTFojoxYVZhBRQAvDsYCT7rQFc-Wcw=w800-ft");
    define("IMG_CARDNOTFOUND","example.com");
    define("IMG_NOMOVIEIMG","https://lh3.googleusercontent.com/fife/ABSRlIo9HHHFUZENAJQRFz07cw_Va2T0W64qX0XCGJkp1g9c-asUjguqOq-Nyesz1z-du_hH7TrkrhowLzZovQKxTeY9V_ATnGFVV5GkG1ViJNle86rGgCWGCDIHOpIIlOqlqHYxaGpgju7v-_jrY-IoNG4Jui2MthmY-0hVewIbELyZ7kMqTwfHR2qfbFeZd36Rmyhnq7jOzeHKE_oSLTzTd2xrzE1u-8HJqcJFwVWVLLPRN0WaaN_44L-qxMstP5ti8jswIR2lm2xTJ0W6vzVcVKHNpbrJf8U3nOCDSFm3w56neaF43ByHHS3rcFHLfjY1BOYADGAsXG1LFub6rjEmt0I7E0OQLGZqb6FL-PrCIo9e21fgdDQOP-XslpwhbKaGnjLEPxmYkyGhC_a54HwjFl2VZ4gefLOvsMB9hMGJvcTci9RQBkjOoMJVg2WEiFtN2E7tFfXAftVLeb8Ct35jfkmjY7_7-rMAPHohWRrrCHtNaMEgY4oX2ofTK1cYFzzNB5C5WYsPQSBTvg0yF6G_vpYOSsPcePjMXN2PREgEzXzLoqHSIWIOhY8xf3XK8bPwvLd0J0kIknoH8TNzkbRWb5jm1zc_b5tWS8UBiF_6q4ghO753fC8ZxZ2ZSSGizZDwzeO0gCrCTqk0cFrM_oXOicfhxT3RyKJsNRisxmxA5KpniiaVPiWGPTC4LtTq6PO-cGb8szXZKEPQcQIj1KeJDswPjwWzCpbptR8=w1366-h251-ft");
    define("IMG_ICONLOGO","ttps://lh3.googleusercontent.com/u/0/d/1vVr75XnwbS4cd1avWt6JvznVB31CIX0p=w1366-h345-iv1");
    define("IMG_VISA","https://lh3.googleusercontent.com/u/0/d/1bvBFH9zTyM4kYTnQOJhBdNZQ5juPrXJr=w1366-h355-iv1");
    define("IMG_MASTER","https://lh3.googleusercontent.com/u/0/d/16sDLKaxkRzx-g9hZCdy5JgAVG4SKYmIB=w800-iv1");
    define("IMG_AMERICAN","https://lh3.googleusercontent.com/u/0/d/1mbhjy0l0lPxLWjVcJ2oHN0LCSp5KoAEk=w800-iv1");
    define("IMG_CART","https://lh3.googleusercontent.com/fife/ABSRlIosSKo3p4ODMj9Whm4Nnx8kDyOrysqj6mXq9MiBbZXOZYxgC4g2CJCtokMLlmo1T3lY-rwkMPN2QB515qnr8E7KQzOpnAehj1ayiWwS9csF_tsWXru5q0VAbKxtCbteWRPpBM7-1sM44C5x6lPj2fWpnc9zm6Wno1S9TM2S9gyjIpmCODiAtTsssS0H7YtzXCtkYZe2Zn23jOOhwZuTk-IzNz-jfeNpYzGTYoFLuJbVBbISpF-ACu0Ffu-1sb7b5IcECLo-HpDlpUUGeBz95ASYx3Pwwmwm_McI90CoHEwUuIOPJEeJgOQ2RFlG014N7W755YJY8qFKY2s76R2YbALo0luHveq5LK3FF4o5ue14w3ACV_6M3xUo3_xrB2KS8Bxa3nvSXGRM89j-wm3hOSY4GLi7MJMes8DMNrqv7J2m4_DrvlNNfc50RimDLbVuZddRfjybpgzp7LXTeejtbKROFlPteTNWjUiHzh7ntNs1wEjao8KlrPPCTzYTl3oqe6_BIYl1d71oLnTLGPEokmHQ6jd3SGtUD-LrvaqRVIqLoCsBNx7NcCBxYfGk3CPldDnnAf-SiXoW9G7n1ePfalLFgTxHFzlSdvpwkpBskU_A_n6-BobmDy865pKLOZLhzBpUS2Gsnq0Gr_1Jj1rtc46nvl_DOjzlHOb6D9QcrPkASkX1V5YVq9c7xA-6vnoEqn9Z4VbYaOYNuIutweNXv0qN7Q3W3cta35g=w1366-h251-ft");

?>

