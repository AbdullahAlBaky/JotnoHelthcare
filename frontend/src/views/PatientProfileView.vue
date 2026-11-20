
<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '../services/api'

const router = useRouter()

const user = ref<any>(null)
const loading = ref(true)
const errorMessage = ref('')

onMounted(async () => {
  const token =
    localStorage.getItem('auth_token') ||
    sessionStorage.getItem('auth_token')

  if (!token) {
    router.push('/login')
    return
  }

  try {
    const response = await api.get('/user', {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    })

    user.value = response.data
  } catch (error: any) {
    errorMessage.value =
      'Unable to load profile information.'
  } finally {
    loading.value = false
  }
})

function goDashboard() {
  router.push('/dashboard')
}
</script>

<template>
  <div class="profile-page">
    <nav class="navbar">
      <h2>Jotno<span>Healthcare</span></h2>
      <button @click="goDashboard">← Dashboard</button>
    </nav>

    <main class="profile-content">
      <h1>My Profile</h1>
      <p class="subtitle">View your personal account information.</p>

      <div v-if="loading" class="message">
        Loading profile...
      </div>

      <div v-else-if="errorMessage" class="error">
        {{ errorMessage }}
      </div>

      <div v-else-if="user" class="profile-card">
        <div class="profile-avatar">👤</div>

        <h2>{{ user.name }}</h2>
        <p class="role">{{ user.role }}</p>

        <div class="details">
          <div class="detail-item">
            <label>Full Name</label>
            <p>{{ user.name }}</p>
          </div>

          <div class="detail-item">
            <label>Email Address</label>
            <p>{{ user.email }}</p>
          </div>

          <div class="detail-item">
            <label>Phone Number</label>
            <p>{{ user.phone || 'Not provided' }}</p>
          </div>

          <div class="detail-item">
            <label>Account Role</label>
            <p>{{ user.role }}</p>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<style scoped>
.profile-page {
  min-height: 100vh;
  background: #effaf8;
  font-family: Arial, sans-serif;
  color: #183b40;
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

button {
  background: #087f78;
  color: white;
  border: none;
  padding: 12px 20px;
  border-radius: 8px;
  cursor: pointer;
}

.profile-content {
  max-width: 750px;
  margin: 45px auto;
  padding: 0 20px;
}

.subtitle {
  color: #829294;
  margin-bottom: 30px;
}

.profile-card {
  background: white;
  padding: 35px;
  border-radius: 15px;
  box-shadow: 0 5px 20px #00000008;
}

.profile-avatar {
  width: 75px;
  height: 75px;
  background: #e0f3ef;
  border-radius: 50%;
  display: grid;
  place-items: center;
  font-size: 35px;
  margin-bottom: 15px;
}

.profile-card h2 {
  margin-bottom: 5px;
}

.role {
  color: #087f78;
  text-transform: capitalize;
  margin-bottom: 30px;
}

.details {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 25px;
}

.detail-item {
  padding: 15px;
  background: #f4f9f8;
  border-radius: 8px;
  overflow-wrap: anywhere;
}

.detail-item label {
  color: #829294;
  font-size: 13px;
}

.detail-item p {
  font-weight: bold;
  margin-bottom: 0;
}

.message {
  padding: 20px;
}

.error {
  color: #dc2626;
  padding: 20px;
}

@media (max-width: 550px) {
  .details {
    grid-template-columns: 1fr;
  }
}
</style>
