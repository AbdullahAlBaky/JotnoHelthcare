
<template>
  <div class="login-page">
    <div class="login-container">

      <div class="login-info">
        <h1>JotnoHealthcare</h1>
        <h2>Welcome Back!</h2>
        <p>
          Your health journey continues here.
          Login to access your personalized healthcare dashboard.
        </p>

        <div class="info-icon">✚</div>
        <h3>Your Health, Our Care.</h3>
      </div>

      <div class="login-form">
        <router-link to="/" class="back-link">
          ← Back to Home
        </router-link>

        <h2>Login to Your Account</h2>
        <p class="subtitle">Enter your credentials to continue.</p>

        <form @submit.prevent="handleLogin">
          <label>Email Address</label>
          <input
            type="email"
            v-model="email"
            placeholder="Enter your email"
            required
          />

          <label>Password</label>
          <input
            type="password"
            v-model="password"
            placeholder="Enter your password"
            required
          />

          <div class="form-options">
            <label class="remember">
              <input type="checkbox" v-model="rememberMe" />
              Remember me
            </label>

            <a href="#" @click.prevent>Forgot password?</a>
          </div>

          <p v-if="message" :class="messageType" class="status-message">
            {{ message }}
          </p>

          <button type="submit" :disabled="loading">
            {{ loading ? 'Logging in...' : 'Login' }}
          </button>
        </form>

        <p class="register-text">
          Don't have an account?
          <router-link to="/register">Create Account</router-link>
        </p>
      </div>

    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '../services/api'

const router = useRouter()

const email = ref('')
const password = ref('')
const rememberMe = ref(false)
const loading = ref(false)
const message = ref('')
const messageType = ref('')

async function handleLogin() {
  loading.value = true
  message.value = ''

  try {
    // Send login request to Laravel API
    const response = await api.post('/login', {
      email: email.value,
      password: password.value,
    })

    // Get token and user information
    const token = response.data.token
    const user = response.data.user

    console.log('Token received:', !!token)
    console.log('User received:', !!user)

    // Check API response
    if (!token || !user) {
      throw new Error('Token or user information is missing.')
    }

    // Save token and user information
    if (rememberMe.value) {
      localStorage.setItem('auth_token', token)
      localStorage.setItem('user', JSON.stringify(user))

      sessionStorage.removeItem('auth_token')
      sessionStorage.removeItem('user')
    } else {
      sessionStorage.setItem('auth_token', token)
      sessionStorage.setItem('user', JSON.stringify(user))

      localStorage.removeItem('auth_token')
      localStorage.removeItem('user')
    }

    // Verify saved token
    const savedToken =
      localStorage.getItem('auth_token') ||
      sessionStorage.getItem('auth_token')

    console.log('Token saved successfully:', !!savedToken)

    if (!savedToken) {
      throw new Error('Unable to save login token.')
    }

    messageType.value = 'success-message'
    message.value = 'Login successful! Redirecting...'

    // Redirect to Patient Dashboard
    await router.push('/dashboard')

  } catch (error: any) {
    console.error('Login error:', error)

    messageType.value = 'error-message'

    message.value =
      error.response?.data?.message ||
      error.message ||
      'Login failed! Please check your email and password.'

  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.login-page {
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 30px;
  background: #effaf8;
  font-family: Arial, sans-serif;
}

.login-container {
  width: 900px;
  max-width: 100%;
  min-height: 550px;
  display: grid;
  grid-template-columns: 1fr 1fr;
  background: white;
  border-radius: 18px;
  overflow: hidden;
  box-shadow: 0 10px 35px #00000012;
}

.login-info {
  background: #087f78;
  color: white;
  padding: 55px 40px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.login-info h1 {
  font-size: 27px;
}

.login-info h2 {
  font-size: 34px;
  margin-bottom: 10px;
}

.login-info p {
  line-height: 1.8;
  color: #e0f5f2;
}

.info-icon {
  font-size: 100px;
  text-align: center;
  margin-top: 30px;
}

.login-info h3 {
  text-align: center;
}

.login-form {
  padding: 45px 40px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.back-link {
  color: #087f78;
  text-decoration: none;
  margin-bottom: 35px;
}

.login-form h2 {
  color: #183b40;
  font-size: 27px;
  margin-bottom: 5px;
}

.subtitle {
  color: #829294;
  margin-bottom: 30px;
}

.login-form form {
  display: flex;
  flex-direction: column;
}

.login-form form > label {
  font-weight: bold;
  color: #183b40;
  margin-bottom: 9px;
}

.login-form input:not([type="checkbox"]) {
  padding: 13px;
  border: 1px solid #dce7e6;
  border-radius: 8px;
  margin-bottom: 22px;
  outline: none;
}

.login-form input:focus {
  border-color: #087f78;
}

.form-options {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 8px;
  margin-bottom: 25px;
  font-size: 13px;
}

.remember {
  display: flex;
  align-items: center;
  gap: 5px;
  color: #617477;
}

.form-options a,
.register-text a {
  color: #087f78;
  text-decoration: none;
  font-weight: bold;
}

button {
  padding: 14px;
  border: none;
  border-radius: 8px;
  background: #087f78;
  color: white;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
}

button:hover {
  background: #066a64;
}

button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.status-message {
  font-size: 13px;
  margin-bottom: 15px;
}

.success-message {
  color: #087f78;
}

.error-message {
  color: #dc2626;
}

.register-text {
  text-align: center;
  margin-top: 25px;
  color: #617477;
  font-size: 14px;
}

@media (max-width: 700px) {
  .login-container {
    grid-template-columns: 1fr;
  }

  .login-info {
    padding: 30px;
  }

  .info-icon {
    font-size: 55px;
    margin-top: 10px;
  }

  .login-form {
    padding: 30px 25px;
  }
}
</style>
