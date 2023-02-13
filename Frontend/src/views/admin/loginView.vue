<template>
<v-container>
    <v-row class="text-center mt-10" align="center">
        <v-col cols="12" sm="8" md="6" class="mx-auto ">
            <v-card>
                <v-card-title>
                    <h2 class="headline font-weight-bold mb-5 text-center">
                        Login
                    </h2>
                </v-card-title>
                <v-card-text>
                    <v-form>
                        <v-text-field label="Email" name="email" prepend-icon="mdi-email" type="email" v-model="email" required></v-text-field>
                        <v-text-field label="Password" name="password" prepend-icon="mdi-lock" type="password" v-model="password" required></v-text-field>
                        <div class="text-center">
                            <v-btn color="success" class="mr-4" @click="login">Login</v-btn>
                        </div>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</v-container>
</template>

<script>
import vueAxios from '../../vueAxios'

export default {
    name: 'loginView',
    data() {
        return {
            email: '',
            password: ''
        }
    },
    methods: {
        login() {
            const data = {
                email: this.email,
                password: this.password
            }
            vueAxios.post('/api/login', data)
                .then(response => {
                    localStorage.setItem('token', response.data.token);

                    alert('Login successful')
                    this.$router.push({
                        path: '/admin/dashboard'
                    })
                })
                .catch((error) => {
                    console.log(error)
                    alert('Usuario o contraseña incorrectos')
                })
        },
    }
}
</script>
