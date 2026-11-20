
<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '../services/api'

const router = useRouter()

const user = ref<any>(
  JSON.parse(
    localStorage.getItem('user') ||
    sessionStorage.getItem('user') ||
    'null'
  )
)

const loggingOut = ref(false)

function goHome() {
  router.push('/')
}

function goDashboard() {
  router.push('/dashboard')
}

function goProfile() {
  router.push('/profile')
}

function goMedicalHistory() {
  router.push('/medical-history')
}

// Logout Function
async function logout() {
  if (loggingOut.value) return

  loggingOut.value = true

  const token =
    localStorage.getItem('auth_token') ||
    sessionStorage.getItem('auth_token')

  try {
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
  } catch (error) {
    console.error('Logout API error:', error)
  } finally {
    localStorage.removeItem('auth_token')
    localStorage.removeItem('user')

    sessionStorage.removeItem('auth_token')
    sessionStorage.removeItem('user')

    await router.replace('/login')
  }
}
</script>

<template>
  <div class="dashboard">

    <!-- Sidebar -->
    <aside class="sidebar">
      <h2 class="logo">Jotno<span>Healthcare</span></h2>

      <div class="sidebar-menu">
        <p class="menu-label">MAIN MENU</p>

        <a href="#" class="menu-item" @click.prevent="goDashboard">
          <span>🏠</span> Dashboard
        </a>

        <a href="#" class="menu-item" @click.prevent="goProfile">
          <span>👤</span> My Profile
        </a>

        <a href="#" class="menu-item" @click.prevent="goMedicalHistory">
          <span>📋</span> Medical History
        </a>

        <a href="#" class="menu-item" @click.prevent>
          <span>🩺</span> Health Monitoring
        </a>

        <a href="#" class="menu-item" @click.prevent>
          <span>👨‍⚕️</span> Doctor Consultation
        </a>

        <a href="#" class="menu-item" @click.prevent>
          <span>🔔</span> Notifications
        </a>
      </div>

      <!-- Sidebar Bottom Buttons -->
      <div class="sidebar-bottom">

        <button
          class="logout-button"
          @click="logout"
          :disabled="loggingOut"
        >
          {{ loggingOut ? 'Logging out...' : '🚪 Logout' }}
        </button>

        <button class="home-button" @click="goHome">
          ← Back to Home
        </button>

      </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">

      <header class="topbar">
        <div>
          <h2>Patient Dashboard</h2>
          <p>Manage your healthcare journey</p>
        </div>

        <!-- Clickable User Profile -->
        <div
          class="user-info"
          @click="goProfile"
          title="View My Profile"
          role="button"
          tabindex="0"
          @keydown.enter="goProfile"
        >
          <div class="avatar">👤</div>

          <div>
            <strong>{{ user?.name || 'Patient' }}</strong>
            <p>{{ user?.role || 'Patient' }}</p>
          </div>
        </div>
      </header>

      <!-- Welcome Section -->
      <section class="welcome">
        <div>
          <h1>
            Welcome back, {{ user?.name || 'Patient' }}!
          </h1>

          <p>
            Your health matters to us. Stay updated with your healthcare
            information and monitoring activities.
          </p>
        </div>

        <div class="welcome-icon">✚</div>
      </section>

      <!-- Statistics -->
      <section class="stats-grid">

        <div class="stat-card">
          <div class="stat-icon purple">📋</div>

          <div>
            <h3>Medical Records</h3>
            <p>View your health records</p>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-icon green">🩺</div>

          <div>
            <h3>Health Monitoring</h3>
            <p>Track your observations</p>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-icon orange">👨‍⚕️</div>

          <div>
            <h3>Consultations</h3>
            <p>Doctor consultation details</p>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-icon blue">🔔</div>

          <div>
            <h3>Notifications</h3>
            <p>Stay updated</p>
          </div>
        </div>

      </section>

      <!-- Healthcare Services -->
      <section class="section">

        <div class="section-heading">
          <h2>Healthcare Services</h2>
          <p>Access your personal healthcare services.</p>
        </div>

        <div class="service-grid">

          <!-- My Profile -->
          <div
            class="service-card clickable-card"
            @click="goProfile"
            role="button"
            tabindex="0"
            @keydown.enter="goProfile"
          >
            <div class="service-icon">👤</div>

            <h3>My Profile</h3>

            <p>
              View and manage your personal information.
            </p>

            <span class="view-link">View Profile →</span>
          </div>

          <!-- Medical History -->
          <div
            class="service-card clickable-card"
            @click="goMedicalHistory"
            role="button"
            tabindex="0"
            @keydown.enter="goMedicalHistory"
          >
            <div class="service-icon">📋</div>

            <h3>Medical History</h3>

            <p>
              View your medical history, health records and reports.
            </p>

            <span class="view-link">View History →</span>
          </div>

          <!-- Health Monitoring -->
          <div class="service-card">
            <div class="service-icon">🩺</div>

            <h3>Health Monitoring</h3>

            <p>
              Monitor your health observations and updates.
            </p>

            <span class="view-link">Monitor Health →</span>
          </div>

          <!-- Doctor Consultation -->
          <div class="service-card">
            <div class="service-icon">👨‍⚕️</div>

            <h3>Doctor Consultation</h3>

            <p>
              Access doctor consultations and care information.
            </p>

            <span class="view-link">View Consultation →</span>
          </div>

          <!-- Notifications -->
          <div class="service-card">
            <div class="service-icon">🔔</div>

            <h3>Notifications</h3>

            <p>
              Receive healthcare reminders and important updates.
            </p>

            <span class="view-link">View Notifications →</span>
          </div>

          <!-- AI Health Assessment -->
          <div class="service-card">
            <div class="service-icon">🤖</div>

            <h3>AI Health Assessment</h3>

            <p>
              View preliminary AI-generated health assessments
              for doctor review.
            </p>

            <span class="view-link">AI Assessment →</span>
          </div>

        </div>
      </section>

      <!-- Footer -->
      <footer>
        © 2026 JotnoHealthcare. All rights reserved.
      </footer>

    </main>
  </div>
</template>

<style scoped>
* {
  box-sizing: border-box;
}

.dashboard {
  min-height: 100vh;
  display: flex;
  background: #f4f9f8;
  font-family: Arial, sans-serif;
  color: #183b40;
}

/* Sidebar */
.sidebar {
  width: 255px;
  min-height: 100vh;
  background: white;
  padding: 30px 20px;
  display: flex;
  flex-direction: column;
  box-shadow: 2px 0 12px #00000008;
  flex-shrink: 0;
}

.logo {
  color: #087f78;
  font-size: 23px;
  margin: 0 0 45px 5px;
}

.logo span {
  color: #183b40;
}

.menu-label {
  font-size: 11px;
  font-weight: bold;
  color: #9aabab;
  margin: 0 0 15px 10px;
  letter-spacing: 1px;
}

.sidebar-menu {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.menu-item {
  display: flex;
  align-items: center;
  gap: 13px;
  padding: 14px 12px;
  text-decoration: none;
  color: #617477;
  border-radius: 8px;
  font-size: 14px;
  transition: 0.2s;
  cursor: pointer;
}

.menu-item:hover {
  background: #e8f7f4;
  color: #087f78;
  font-weight: bold;
}

.sidebar-bottom {
  margin-top: auto;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.sidebar-bottom button {
  width: 100%;
  padding: 13px;
  border: none;
  border-radius: 8px;
  font-weight: bold;
  cursor: pointer;
  transition: 0.2s;
}

/* Logout Button */
.sidebar-bottom .logout-button {
  background: #fff0f0;
  color: #d9534f;
}

.sidebar-bottom .logout-button:hover {
  background: #d9534f;
  color: white;
}

.sidebar-bottom .logout-button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* Back to Home Button */
.sidebar-bottom .home-button {
  background: #e8f7f4;
  color: #087f78;
}

.sidebar-bottom .home-button:hover {
  background: #d4efea;
}

/* Main Content */
.main-content {
  flex: 1;
  padding: 30px 40px;
  min-width: 0;
}

.topbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
}

.topbar h2 {
  margin: 0 0 7px;
  font-size: 23px;
}

.topbar p {
  margin: 0;
  color: #829294;
  font-size: 13px;
}

/* User Profile */
.user-info {
  display: flex;
  align-items: center;
  gap: 12px;
  cursor: pointer;
  padding: 8px 12px;
  border-radius: 10px;
  transition: 0.2s;
  user-select: none;
}

.user-info:hover {
  background: #e8f7f4;
}

.user-info:focus-visible {
  outline: 2px solid #087f78;
}

.avatar {
  width: 43px;
  height: 43px;
  background: #e0f3ef;
  border-radius: 50%;
  display: grid;
  place-items: center;
  font-size: 21px;
  flex-shrink: 0;
}

.user-info strong {
  font-size: 14px;
}

.user-info p {
  margin-top: 5px;
}

/* Welcome */
.welcome {
  background: linear-gradient(110deg, #087f78, #12a69a);
  color: white;
  padding: 35px;
  border-radius: 15px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
}

.welcome h1 {
  font-size: 27px;
  margin: 0 0 12px;
}

.welcome p {
  max-width: 600px;
  line-height: 1.7;
  color: #e0f5f2;
  font-size: 14px;
  margin: 0;
}

.welcome-icon {
  font-size: 75px;
  opacity: 0.8;
}

/* Statistics */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 18px;
  margin: 28px 0 40px;
}

.stat-card {
  background: white;
  padding: 20px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  gap: 13px;
  border: 1px solid #e7eeee;
}

.stat-icon {
  width: 45px;
  height: 45px;
  border-radius: 10px;
  display: grid;
  place-items: center;
  font-size: 22px;
  flex-shrink: 0;
}

.purple {
  background: #f0eaff;
}

.green {
  background: #e3f7ed;
}

.orange {
  background: #fff1df;
}

.blue {
  background: #e5f1ff;
}

.stat-card h3 {
  font-size: 13px;
  margin: 0 0 7px;
}

.stat-card p {
  color: #829294;
  font-size: 11px;
  margin: 0;
}

/* Services */
.section-heading {
  margin-bottom: 22px;
}

.section-heading h2 {
  font-size: 21px;
  margin: 0 0 8px;
}

.section-heading p {
  color: #829294;
  font-size: 13px;
  margin: 0;
}

.service-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}

.service-card {
  background: white;
  padding: 25px;
  border-radius: 12px;
  border: 1px solid #e7eeee;
  transition: 0.2s;
}

.service-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 20px #0000000c;
}

.clickable-card {
  cursor: pointer;
}

.clickable-card:focus-visible {
  outline: 2px solid #087f78;
}

.service-icon {
  font-size: 35px;
  margin-bottom: 15px;
}

.service-card h3 {
  color: #087f78;
  font-size: 17px;
  margin: 0 0 10px;
}

.service-card p {
  color: #718487;
  font-size: 13px;
  line-height: 1.7;
  min-height: 45px;
}

.view-link {
  display: inline-block;
  margin-top: 10px;
  color: #087f78;
  font-size: 13px;
  font-weight: bold;
}

/* Footer */
footer {
  text-align: center;
  color: #9aabab;
  font-size: 12px;
  padding: 35px 0 10px;
}

/* Responsive */
@media (max-width: 1100px) {
  .stats-grid {
    grid-template-columns: repeat(2, 1fr);
  }

  .service-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 750px) {
  .dashboard {
    flex-direction: column;
  }

  .sidebar {
    width: 100%;
    min-height: auto;
    padding: 20px;
  }

  .logo {
    margin-bottom: 20px;
  }

  .sidebar-menu {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
  }

  .sidebar-bottom {
    margin-top: 20px;
  }

  .main-content {
    padding: 25px 20px;
  }

  .topbar {
    gap: 15px;
  }
}

@media (max-width: 500px) {
  .stats-grid,
  .service-grid {
    grid-template-columns: 1fr;
  }

  .welcome {
    padding: 25px;
  }

  .welcome h1 {
    font-size: 21px;
  }

  .welcome-icon {
    font-size: 45px;
  }
}
</style>
