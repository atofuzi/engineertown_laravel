<template>
    <div>
        <div v-for="(skill,index) in skills" :key="index">
                <input type="hidden" :name="index" value=0 >
                <label><input type="checkbox" :name="index" value=1 :checked="checked(index)">{{ skill }}</label><br>
        </div>
    </div>
</template>


<script>
export default{
    name: "SkillsComponent",
    props:[
        'UserSkills',
        'old'
    ],   
    data(){
        return{
            skills: {
                html_flg: 'HTML',
                css_flg: 'CSS',
                js_jq_flg: 'jacascript ・ jquery',
                sql_flg: 'SQL',
                java_flg: 'JAVA',
                php_flg: 'PHP',
                php_oj_flg: 'PHP（オブジェクト指向)',
                php_fw_flg: 'PHP（フレームワーク)',
                ruby_flg: 'ruby',
                rails_flg: 'rails',
                laravel_flg: 'laravel',
                swift_flg: 'swift',
                scala_flg: 'scala',
                go_flg: 'go',
                kotolin_flg: 'kotolin'
            }
        }
    },
    computed: {
        checked: function(){
            self = this;
            return function(index){
                if( self.old[index] == null && self.UserSkills[index] == 1 ){
                    return true
                }else if( self.old[index] == 1){
                    return true
                }else{
                    return false
                }
            }
        }
    }
}
</script>