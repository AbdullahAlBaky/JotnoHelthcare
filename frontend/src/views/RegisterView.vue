
<template>
  <div class="register-page">
    <div class="register-container">

      <div class="register-info">
        <h1>JotnoHealthcare</h1>
        <h2>Join Our Healthcare Community</h2>
        <p>
          Create your account and experience connected,
          doctor-supervised healthcare from home.
        </p>

        <div class="info-icon">✚</div>
        <h3>Your Health, Our Care.</h3>
      </div>

      <div class="register-form">
        <router-link to="/" class="back-link">
          ← Back to Home
        </router-link>

        <h2>Create Account</h2>
        <p class="subtitle">Fill in your information to register.</p>

        <form @submit.prevent="handleRegister">

          <label>Full Name</label>
          <input
            type="text"
            v-model="name"
            placeholder="Enter your full name"
            required
          />

          <label>Email Address</label>
          <input
            type="email"
            v-model="email"
            placeholder="Enter your email"
            required
          />

          <label>Phone Number</label>
          <input
            type="tel"
            v-model="phone"
            placeholder="Enter your phone number"
            required
          />

          <label>Select Your Role</label>
          <select v-model="role" required>
            <option value="" disabled>Select your role</option>
            <option value="patient">Patient</option>
            <option value="caregiver">Caregiver</option>
          </select>

          <label>Password</label>
          <input
            type="password"
            v-model="password"
            placeholder="Create a password"
            minlength="8"
            required
          />

          <label>Confirm Password</label>
          <input
            type="password"
            v-model="confirmPassword"
            placeholder="Confirm your password"
            minlength="8"
            required
          />

          <button type="submit" :disabled="isLoading">
            {{ isLoading ? 'Creating Account...' : 'Create Account' }}
          </button>

          <p
            v-if="message"
            class="api-message"
            :class="messageType"
          >
            {{ message }}
          </p>

        </form>

        <p class="login-text">
          Already have an account?
          <router-link to="/login">Login</router-link>
        </p>
      </div>

    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import api from '../services/api'

const name = ref('')
const email = ref('')
const phone = ref('')
const role = ref('')
const password = ref('')
const confirmPassword = ref('')

const message = ref('')
const messageType = ref<'success' | 'error'>('success')
const isLoading = ref(false)

async function handleRegister() {
  message.value = ''

  if (password.value !== confirmPassword.value) {
    message.value = 'Passwords do not match!'
    messageType.value = 'error'
    return
  }

  isLoading.value = true

  try {
    const response = await api.post('/register', {
      name: name.value,
      email: email.value,
      phone: phone.value,
      role: role.value,
      password: password.value,
      password_confirmation: confirmPassword.value,
    })

    localStorage.setItem('auth_token', response.data.token)

    message.value = 'Registration successful! Your account has been created.'
    messageType.value = 'success'

    name.value = ''
    email.value = ''
    phone.value = ''
    role.value = ''
    password.value = ''
    confirmPassword.value = ''

  } catch (error: any) {
    console.error('Registration Error:', error)

    if (error.response) {
      console.log('Status:', error.response.status)
      console.log('Server Response:', error.response.data)

      const errors = error.response.data.errors

      message.value = errors
        ? Object.values(errors).flat().join(' ')
        : error.response.data.message || 'Server error occurred.'

    } else if (error.request) {
      message.value = 'Backend server is not responding. Check Laravel server.'

    } else {
      message.value = error.message || 'Something went wrong.'
    }

    messageType.value = 'error'

  } finally {
    isLoading.value = false
  }
}
</script>

<style scoped>
.register-page {
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 30px;
  background: #effaf8;
  font-family: Arial, sans-serif;
}

.register-container {
  width: 1000px;
  max-width: 100%;
  display: grid;
  grid-template-columns: 0.9fr 1.1fr;
  background: white;
  border-radius: 18px;
  overflow: hidden;
  box-shadow: 0 10px 35px #00000012;
}

.register-info {
  background: #087f78;
  color: white;
  padding: 55px 40px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.register-info h1 {
  font-size: 27px;
}

.register-info h2 {
  font-size: 32px;
  line-height: 1.3;
}

.register-info p {
  line-height: 1.8;
  color: #e0f5f2;
}

.info-icon {
  font-size: 100px;
  text-align: center;
  margin-top: 30px;
}

.register-info h3 {
  text-align: center;
}

.register-form {
  padding: 35px 45px;
}

.back-link {
  display: inline-block;
  color: #087f78;
  text-decoration: none;
  margin-bottom: 20px;
}

.register-form h2 {
  color: #183b40;
  font-size: 27px;
  margin-bottom: 5px;
}

.subtitle {
  color: #829294;
  margin-bottom: 22px;
}

.register-form form {
  display: flex;
  flex-direction: column;
}

.register-form label {
  font-weight: bold;
  color: #183b40;
  margin-bottom: 8px;
  font-size: 14px;
}

.register-form input,
.register-form select {
  padding: 12px;
  border: 1px solid #dce7e6;
  border-radius: 8px;
  margin-bottom: 17px;
  outline: none;
  background: white;
}

.register-form input:focus,
.register-form select:focus {
  border-color: #087f78;
}

.register-form button {
  padding: 14px;
  border: none;
  border-radius: 8px;
  background: #087f78;
  color: white;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  margin-top: 5px;
}

.register-form button:hover {
  background: #066a64;
}

.register-form button:disabled {
  background: #83aaa7;
  cursor: not-allowed;
}

.api-message {
  margin-top: 15px;
  padding: 12px;
  border-radius: 8px;
  font-size: 14px;
  line-height: 1.5;
  overflow-wrap: anywhere;
}

.api-message.success {
  background: #e6f7ed;
  color: #16733b;
}

.api-message.error {
  background: #fdeaea;
  color: #c62828;
}

.login-text {
  text-align: center;
  margin-top: 20px;
  color: #617477;
  font-size: 14px;
}

.login-text a {
  color: #087f78;
  font-weight: bold;
  text-decoration: none;
}

@media (max-width: 750px) {
  .register-container {
    grid-template-columns: 1fr;
  }

  .register-info {
    padding: 30px;
  }

  .info-icon {
    font-size: 55px;
    margin-top: 10px;
  }

  .register-form {
    padding: 30px 25px;
  }
}
</style>
