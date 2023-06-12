<template>
    <div>
      <DesktopNavLogin />
      <v-app id="inspire">
        <v-main>
          <v-container fluid fill-height>
            <v-layout align-center justify-center>
              <v-flex xs12 sm8 md4>
                <v-card class="elevation-12">
                  <v-toolbar dark color="primary">
                    <v-toolbar-title>Đăng nhập</v-toolbar-title>
                  </v-toolbar>
                  <v-card-text>
                    <v-form>
                      <v-text-field
                        name="email"
                        label="Email"
                        type="text"
                        v-model="email"
                        @blur="$v.email.$touch()"
                        :error-messages="errors.email"
                         @keydown.enter.prevent="loginHandler"
                      ></v-text-field>
                      <div v-if="$v.email.$error" class="form-error">
                        <span v-if="!$v.email.required"
                          >Yêu cầu nhập trường dữ liệu này</span
                        >
                        <span v-if="!$v.email.email"
                          >Yêu cầu nhập đúng email</span
                        >
                      </div>
                      <v-text-field
                        id="password"
                        name="password"
                        label="Password"
                        type="password"
                        v-model="password"
                        @blur="$v.password.$touch()"
                        :error-messages="errors.password"
                        @keydown.enter.prevent="loginHandler"
                      ></v-text-field>
                      <div v-if="$v.password.$error" class="form-error">
                        <span v-if="!$v.password.required"
                          >Yêu cầu nhập trường dữ liệu này</span
                        >
                      </div>
                    </v-form>
                  </v-card-text>
                  <v-card-actions>
                    <p>
                      Bạn chưa có tài khoản? 
                      <nuxt-link to="/users/register">Đăng ký</nuxt-link>
                    </p>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" @click="loginHandler">Đăng nhập</v-btn>
                  </v-card-actions>
                </v-card>
              </v-flex>
            </v-layout>
          </v-container>
        </v-main>
      </v-app>
    </div>
  </template>
  
<script>
import { required, email } from 'vuelidate/lib/validators';
import { mapActions, mapGetters } from 'vuex';
import {LOGIN} from '@/store/login';
export default {
data() {
  return {
    email: '',
    password: '',
    errors: {},
  }
},

methods: {
  async loginHandler() {
    let payload = {
      email: this.email,
      password: this.password
    }

     this.$store.dispatch(LOGIN, payload).then(data => {
  if (data && data.status) {
    console.log(1);
    alert("Đăng nhập thành công");
    const permission = data.data.user.department_id; // Truy cập department_id từ data.data.user
    if (permission == 1 || permission == 3) {
      this.$router.push(`../manager/`);
    } else {
      this.$router.push(`../`);
    }
    } else {
    alert("Thông tin tài khoản mật khẩu không chính xác");
    }
  });

},

   
},
  computed: {
  ...mapGetters({
      isAuthentication: "isAuthentication",
    })
  },

    validations: {
      email: { required, email },
      password: { required },
    },
}
  </script>
  
  <style>
  .form-error {
    color: red;
  }
  </style>




    <!-- this.$store.dispatch(LOGIN, payload).then(data => {
  if (data && data.status) {
    console.log(1);
    alert("Đăng nhập thành công");
    const permission = data.data.user.department_id; // Truy cập department_id từ data.data.user
    if (permission == 1 || permission == 3) {
      this.$router.push(`../manager/`);
    } else {
      this.$router.push(`../`);
    }
    } else {
    alert("Thông tin tài khoản mật khẩu không chính xác");
    }
  }); -->

<!-- 
loginHandler() {
        this.$v.$touch()
        if (!this.$v.$invalid) {

          this.$axios
            .post('http://127.0.0.1:8000/api/users/login',{
              email: this.email,
              password: this.password,
            })
            .then((response) => {
              console.log(response);
              // console.log(response.data.users.department_id);
              if(response.data.message == true){
                alert("Đăng nhập thành công");

                const id_session = response.data.users.id;
                localStorage.setItem('id_session', id_session);

                const permission = response.data.users.department_id;
                if(permission == 1 || permission == 3){
                  this.$router.push(`../manager/`);
                }
                else{
                  this.$router.push(`../`);
                }
              }else{
                alert("Thông tin tài khoản mật khẩu không chính xác");
              }   
            })
            .catch((error) => {
              console.log(error);
            });   

        } else {
          alert('Vui lòng nhập đủ thông tin!')
        }
      }, -->



       <!-- this.$store.dispatch(LOGIN, payload).then(data => {
      if (data && data.status) {
     console.log(data.data.access_token);
      commit('setAuthentication', true);
      Cookies.saveToken(data.data.access_token);
      Cookies.saveRefreshToken(data.data.refresh_token); // Lưu refresh token vào lưu trữ
       alert("Đăng nhập thành công");
      const permission = data.data.user.department_id; // Truy cập department_id từ data.data.user
    if (permission == 1 || permission == 3) {
      this.$router.push(`../manager/`);
    } else {
      this.$router.push(`../`);
    }
    } else {
    alert("Thông tin tài khoản mật khẩu không chính xác");
    }
  }); -->