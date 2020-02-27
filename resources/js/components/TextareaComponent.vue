<template>
    <div>
        <textarea name="profile" v-model="message"></textarea>
        <p class="counter-text"><span>{{ charaCount }}</span>/255文字</p>
    </div>
</template>

<script>
export default{
    name: "TextareaComponent",
    props:[
        'inputVal'
    ],
    data(){
        return{
            message: this.inputVal
        }
    },
    computed:{
        charaCount: function() {
            return this.message.length;
    }
    }
}

</script>