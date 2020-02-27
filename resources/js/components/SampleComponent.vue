<template>
    <div>
        <h2>カウンター</h2>
        <p>
            Count : <span :class="numberClass">{{ number }}</span>
        </p>
        <button @click="countDown">-1</button>
        <button @click="countUp">+1</button>
        <p>取得したデータ{{data}}</p>
        <p>終了</p>
    </div>
</template>

<script>
export default{
    name: "SampleComponent",
    data(){
        return{
            number:0,
            data:""
        }
    },
    computed: {
        numberClass: function () {
            return { 
                'positive': (this.number > 0),
                'negative': (this.number < 0)
            }
        }
    },
    methods: {
        countDown: function() {
            this.number--
        },
        countUp: function() {
            this.number++
        }
    },
    mounted() {
        axios.get('/info').then(response => this.data = response.data)
    }
}
</script>

<style scoped>
    p {
        margin: 10px;
    }
    .positive {
        color: blue;
    }
    .negative {
        color: red;
    }
</style>