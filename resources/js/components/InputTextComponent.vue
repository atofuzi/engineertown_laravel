<template>
    <input type="text" :name="content" :id="content" :class="content" v-model="inputText" :placeholder="placeholder">
</template>

<script>
export default{
    name:"InputTextComponent",
    props:[
        'inputText',
        'inputContent',
        'placeholder'
    ],
    data(){
        return{ 
            content: this.inputContent
        }
    }
}
</script>
