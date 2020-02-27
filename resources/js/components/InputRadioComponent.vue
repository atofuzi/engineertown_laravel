<template>
    <div>
        <label v-for="(item,index) in items" :key="index">
            <input 
                type="radio" 
                :name="id" 
                v-model="picked" 
                :value="index"
            />
            {{ item }}
        </label>
    </div>
</template>

<script>
export default{
   name: "InputRagioComponent",
   props:[
       'radioChecked',
       'old',
       'id',
       'choices'
   ],
   data(){
       return{
           picked: 2,
           items: this.choices,
       }
   },
    created(){
        if(this.old ==""){
            this.picked = this.radioChecked
        }else{
            this.picked = this.old
        }
    },
}
</script>
