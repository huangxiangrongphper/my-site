<template>
    <button
            class="btn btn-default"
            v-bind:class="{'btn-primary' : voted}"
            v-text="text"
            v-on:click="vote"
    ></button>
</template>

<script>
    export default {
        props:['answer','count'],
        mounted() {
            axios.post('/api/answer/' + this.answer + '/votes/users').then(response => {
                this.voted = response.data.voted
            })
        },
        data() {
            return {
                voted :false ,
                voted_count: this.count
            }
        },
        computed: {
            text() {
                return this.count
            }
        },
        methods:{
            vote() {
                axios.post('/api/answer/vote',{'answer':this.answer}).then(response => {
                    this.voted = response.data.followed
                    response.data.followed ? this.voted_count ++ : this.voted_count --
                })
            }
        }
    }
</script>
