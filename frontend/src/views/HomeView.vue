
<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'
import api from '../services/api'

const router = useRouter()

const apiMessage = ref('Checking backend connection...')
const apiConnected = ref(false)
const loading = ref(false)

const user = ref<any>(
  JSON.parse(
    localStorage.getItem('user') ||
    sessionStorage.getItem('user') ||
    'null'
  )
)

const isLoggedIn = computed(() => {
  return !!(
    localStorage.getItem('auth_token') ||
    sessionStorage.getItem('auth_token')
  )
})

onMounted(async () => {
  try {
    const response = await api.get('/test')

    apiMessage.value = response.data.message
    apiConnected.value = true
  } catch (error) {
    apiMessage.value = 'Backend connection failed!'
    apiConnected.value = false
    console.error('API Error:', error)
  }
})

async function handleLogout() {
  loading.value = true

  try {
    const token =
      localStorage.getItem('auth_token') ||
      sessionStorage.getItem('auth_token')

    if (token) {
      await api.post(
        '/logout',
        {},
        {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        }
      )
    }

    localStorage.removeItem('auth_token')
    localStorage.removeItem('user')
    sessionStorage.removeItem('auth_token')
    sessionStorage.removeItem('user')

    user.value = null

    await router.push('/login')
  } catch (error: any) {
    console.error('Logout Error:', error)

    if (error.response?.status === 401) {
      localStorage.removeItem('auth_token')
      localStorage.removeItem('user')
      sessionStorage.removeItem('auth_token')
      sessionStorage.removeItem('user')

      user.value = null
      await router.push('/login')
    } else {
      alert('Logout failed! Please try again.')
    }
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="home">
    <nav class="navbar">
      <h2>Jotno<span>Healthcare</span></h2>

      <div class="nav-links">
        <a href="#home">Home</a>
        <a href="#services">Services</a>

        <template v-if="isLoggedIn">
          <span class="user-name">
            Welcome, {{ user?.name || 'User' }}
          </span>

          <button
            class="logout-btn"
            @click="handleLogout"
            :disabled="loading"
          >
            {{ loading ? 'Logging out...' : 'Logout' }}
          </button>
        </template>

        <template v-else>
          <router-link to="/login">Login</router-link>

          <router-link to="/register" class="register-btn">
            Get Started
          </router-link>
        </template>
      </div>
    </nav>

    <section id="home" class="hero">
      <div class="hero-content">
        <p class="tagline">YOUR HEALTH, OUR PRIORITY</p>

        <h1>
          Quality Healthcare<br />
          <span>From Your Home</span>
        </h1>

        <p class="description">
          JotnoHealthcare connects patients, caregivers and doctors
          through smart technology for better home-based healthcare.
        </p>

        <div class="hero-buttons">
          <template v-if="!isLoggedIn">
            <router-link to="/register" class="primary-btn">
              Get Started
            </router-link>

            <router-link to="/login" class="secondary-btn">
              Login
            </router-link>
          </template>
        </div>
      </div>

      <div class="hero-image">
        <div class="health-card">
          <div class="health-icon">✚</div>
          <h2>Healthcare at Your Fingertips</h2>
          <p>Connected Care. Better Living.</p>
        </div>
      </div>
    </section>

    <div class="api-status">
      <p>
        Backend Status:
        <strong :class="apiConnected ? 'connected' : 'disconnected'">
          {{ apiMessage }}
        </strong>
      </p>
    </div>

    <section id="services" class="services">
      <h2>Our Services</h2>

      <p class="section-description">
        Supporting patients throughout their healthcare journey.
      </p>

      <div class="service-grid">
        <div class="service-card">
          <div class="service-icon">👨‍⚕️</div>
          <h3>Doctor Consultation</h3>
          <p>Connect with doctors through online consultations.</p>
        </div>

        <div class="service-card">
          <div class="service-icon">🏥</div>
          <h3>Virtual Care</h3>
          <p>Receive doctor-supervised care from home.</p>
        </div>

        <div class="service-card">
          <div class="service-icon">🤖</div>
          <h3>AI Assistance</h3>
          <p>Get preliminary health insights for doctor review.</p>
        </div>

        <div class="service-card">
          <div class="service-icon">🔔</div>
          <h3>Health Monitoring</h3>
          <p>Track observations and receive important reminders.</p>
        </div>
      </div>
    </section>

    <footer>
      <h3>JotnoHealthcare</h3>
      <p>Your Health, Our Care.</p>
      <p>© 2026 JotnoHealthcare. All rights reserved.</p>
    </footer>
  </div>
</template>

<style scoped>
.home {
  font-family: Arial, sans-serif;
  color: #183b40;
  background: #ffffff;
  min-height: 100vh;
}

.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 22px 8%;
  background: white;
}

.navbar h2 {
  color: #087f78;
}

.navbar h2 span {
  color: #183b40;
}

.nav-links {
  display: flex;
  align-items: center;
  gap: 28px;
}

.nav-links a {
  text-decoration: none;
  color: #183b40;
  font-weight: 600;
}

.register-btn,
.primary-btn {
  background: #087f78;
  color: white !important;
  padding: 12px 22px;
  border-radius: 8px;
}

.user-name {
  color: #087f78;
  font-weight: bold;
}

.logout-btn {
  background: #dc4c4c;
  color: white;
  border: none;
  padding: 12px 22px;
  border-radius: 8px;
  font-weight: bold;
  cursor: pointer;
}

.logout-btn:hover {
  background: #b83232;
}

.logout-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.hero {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 40px;
  padding: 90px 8%;
  background: #effaf8;
}

.hero-content {
  max-width: 550px;
}

.tagline {
  color: #087f78;
  font-weight: bold;
  letter-spacing: 2px;
}

.hero h1 {
  font-size: 48px;
  line-height: 1.2;
}

.hero h1 span {
  color: #087f78;
}

.description {
  color: #617477;
  line-height: 1.8;
  font-size: 17px;
}

.hero-buttons {
  display: flex;
  gap: 15px;
  margin-top: 30px;
}

.hero-buttons a {
  text-decoration: none;
  font-weight: bold;
}

.secondary-btn {
  border: 1px solid #087f78;
  color: #087f78;
  padding: 12px 22px;
  border-radius: 8px;
}

.api-status {
  text-align: center;
  padding: 15px;
  background: #f5faf9;
  border-bottom: 1px solid #e4eeee;
}

.api-status p {
  margin: 0;
}

.connected {
  color: green;
}

.disconnected {
  color: red;
}

.hero-image {
  width: 380px;
  height: 300px;
  background: #d1eeea;
  border-radius: 25px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.health-card {
  background: white;
  padding: 35px;
  border-radius: 18px;
  text-align: center;
  width: 230px;
  box-shadow: 0 10px 35px #00000012;
}

.health-icon {
  color: #087f78;
  font-size: 55px;
}

.health-card p {
  color: #617477;
}

.services {
  padding: 65px 8%;
  text-align: center;
}

.services h2 {
  font-size: 32px;
}

.section-description {
  color: #617477;
  margin-bottom: 35px;
}

.service-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
}

.service-card {
  padding: 28px 18px;
  border: 1px solid #e4eeee;
  border-radius: 14px;
}

.service-icon {
  font-size: 38px;
}

.service-card p {
  color: #617477;
  line-height: 1.6;
}

footer {
  text-align: center;
  padding: 30px;
  background: #effaf8;
  color: #617477;
}

@media (max-width: 768px) {
  .navbar {
    flex-direction: column;
    gap: 20px;
  }

  .nav-links {
    flex-wrap: wrap;
    justify-content: center;
    gap: 15px;
  }

  .hero {
    flex-direction: column;
    padding: 50px 6%;
  }

  .hero h1 {
    font-size: 36px;
  }

  .hero-image {
    width: 100%;
  }

  .service-grid {
    grid-template-columns: 1fr;
  }
}
</style>
