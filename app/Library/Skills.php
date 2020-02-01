<?php

namespace App\Library;

class Skills
{   
    
    const html_flg = 'HTML';
    const css_flg = 'CSS';
    const js_jq_flg = 'javascript・jquery';
    const sql_flg =  'SQL';
    const java_flg = 'JAVA';
    const php_flg = 'PHP';
    const php_oj_flg = 'PHP(オブジェクト指向)';
    const php_fw_flg = 'PHP(フレームワーク)';
    const ruby_flg = 'ruby';
    const rails_flg = 'rails'; 
    const laravel_flg = 'laravel';
    const swift_flg = 'swift';
    const scala_flg = 'scala';
    const go_flg = 'go';
    const kotolin_flg = 'kotolin';

    public static function get($skills){
        switch($skills){
            case 'html_flg':
                    return 'HTML';
                    break;
            case 'css_flg':
                    return 'CSS';
                    break;
            case 'js_jq_flg':
                    return 'javascript・jquery';
                    break;
            case 'sql_flg':
                    return 'SQL';
                    break;
            case 'java_flg':
                    return 'JAVA';
                    break;
            case 'php_flg':
                    return 'PHP';
                    break;
            case 'php_oj_flg':
                    return 'PHP(オブジェクト指向)';
                    break;
            case 'php_fw_flg':
                    return 'PHP(フレームワーク)';
                    break;
            case 'ruby_flg':
                    return 'ruby';
                    break;
            case 'rails_flg':
                    return 'rails';
                    break;  
            case 'laravel_flg':
                    return 'laravel';
                    break;
            case 'swift_flg':
                    return 'swift';
                    break;
            case 'scala_flg':
                    return 'scala';
                    break;
            case 'go_flg':
                    return 'go';
                    break;
            case 'kotolin_flg':
                    return 'kotolin';
                    break;
                    
        }
    }

}

