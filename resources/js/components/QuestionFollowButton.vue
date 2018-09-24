<template>
    <button
            class="btn btn-default"
            v-text="text"
    ></button>
</template>

<script>
    export default {
        props:['question','user'],
        mounted() {
            axios.post('/api/question/follower',{'question':this.question,'user':this.user}).then(response => {
                this.followed = response.data.followed
            })
        },
        data() {
            return {
                followed :false
            }
        },
        computed: {
            text() {
                return this.followed ? '已关注' :'关注该问题'
            }
        }
    }
</script>
