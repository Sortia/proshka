<template>
    <div class="container">
        <hr>
        <div class="row">
            <div class="col-lg-12">
                <textarea readonly name="qwe" id="" cols="30" rows="10" class="form-control">{{messages.join('\n')}}</textarea>
                <hr>
                <input type="text" class="form-control" v-model="textMessage" @keyup.enter="sendMessage">
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            messages: [],
            textMessage: '',
        }
    },
    mounted() {
        window.Echo.channel('laravel_database_chat').listen('MessageEvent', ({message}) => {
            this.messages.push(message)
        })
    },
    methods: {
        sendMessage() {
            axios.post('/messages', { body: this.textMessage });

            this.messages.push(this.textMessage);
            this.textMessage = '';
        }
    }
}
</script>
