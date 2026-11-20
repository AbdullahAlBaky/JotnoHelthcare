
<template>
  <div class="medical-history-page">
    <div class="container">

      <div class="header">
        <div>
          <h1>Medical History</h1>
          <p>Manage your personal medical information.</p>
        </div>

        <button class="back-btn" @click="goDashboard">
          ← Dashboard
        </button>
      </div>

      <div v-if="message" class="message" :class="messageType">
        {{ message }}
      </div>

      <div class="history-card">
        <h2>{{ editingId ? 'Update Medical History' : 'Add Medical History' }}</h2>

        <form @submit.prevent="saveHistory">

          <div class="form-group">
            <label>Blood Group</label>
            <select v-model="form.blood_group">
              <option value="">Select Blood Group</option>
              <option v-for="group in bloodGroups" :key="group" :value="group">
                {{ group }}
              </option>
            </select>
          </div>

          <div class="form-group">
            <label>Previous Diseases</label>
            <textarea v-model="form.previous_diseases"
              placeholder="Enter previous diseases"></textarea>
          </div>

          <div class="form-group">
            <label>Allergies</label>
            <textarea v-model="form.allergies"
              placeholder="Enter your allergies"></textarea>
          </div>

          <div class="form-group">
            <label>Current Medications</label>
            <textarea v-model="form.current_medications"
              placeholder="Enter current medications"></textarea>
          </div>

          <div class="form-group">
            <label>Past Surgeries</label>
            <textarea v-model="form.past_surgeries"
              placeholder="Enter past surgeries"></textarea>
          </div>

          <div class="form-group">
            <label>Family Medical History</label>
            <textarea v-model="form.family_medical_history"
              placeholder="Enter family medical history"></textarea>
          </div>

          <div class="form-group">
            <label>Additional Notes</label>
            <textarea v-model="form.additional_notes"
              placeholder="Additional information"></textarea>
          </div>

          <div class="form-buttons">
            <button type="submit" class="save-btn" :disabled="loading">
              {{ loading ? 'Saving...' : editingId ? 'Update History' : 'Save History' }}
            </button>

            <button
              v-if="editingId"
              type="button"
              class="cancel-btn"
              @click="resetForm"
            >
              Cancel
            </button>
          </div>

        </form>
      </div>

      <div class="history-card records">
        <h2>My Medical Records</h2>

        <p v-if="fetching">Loading medical records...</p>

        <p v-else-if="histories.length === 0">
          No medical history found. Add your first record above.
        </p>

        <div
          v-for="history in histories"
          :key="history.id"
          class="record-item"
        >
          <div class="record-header">
            <h3>{{ history.blood_group || 'Blood group not provided' }}</h3>

            <div class="record-actions">
              <button @click="editHistory(history)" class="edit-btn">
                Edit
              </button>

              <button @click="deleteHistory(history.id)" class="delete-btn">
                Delete
              </button>
            </div>
          </div>

          <p><strong>Previous Diseases:</strong> {{ history.previous_diseases || 'Not provided' }}</p>
          <p><strong>Allergies:</strong> {{ history.allergies || 'Not provided' }}</p>
          <p><strong>Current Medications:</strong> {{ history.current_medications || 'Not provided' }}</p>
          <p><strong>Past Surgeries:</strong> {{ history.past_surgeries || 'Not provided' }}</p>
          <p><strong>Family Medical History:</strong> {{ history.family_medical_history || 'Not provided' }}</p>
          <p><strong>Additional Notes:</strong> {{ history.additional_notes || 'Not provided' }}</p>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '../services/api'

const router = useRouter()

const histories = ref<any[]>([])
const loading = ref(false)
const fetching = ref(false)
const editingId = ref<number | null>(null)

const message = ref('')
const messageType = ref('success')

const bloodGroups = [
  'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'
]

const form = reactive({
  blood_group: '',
  previous_diseases: '',
  allergies: '',
  current_medications: '',
  past_surgeries: '',
  family_medical_history: '',
  additional_notes: ''
})

function getToken() {
  return localStorage.getItem('auth_token') ||
         sessionStorage.getItem('auth_token')
}

function showMessage(text: string, type = 'success') {
  message.value = text
  messageType.value = type
}

function resetForm() {
  editingId.value = null

  Object.assign(form, {
    blood_group: '',
    previous_diseases: '',
    allergies: '',
    current_medications: '',
    past_surgeries: '',
    family_medical_history: '',
    additional_notes: ''
  })
}

async function loadHistories() {
  fetching.value = true

  try {
    const response = await api.get('/medical-histories', {
      headers: {
        Authorization: `Bearer ${getToken()}`
      }
    })

    histories.value = response.data.medical_histories || []
  } catch (error: any) {
    showMessage(
      error.response?.data?.message || 'Could not load medical history.',
      'error'
    )
  } finally {
    fetching.value = false
  }
}

async function saveHistory() {
  loading.value = true

  try {
    const headers = {
      Authorization: `Bearer ${getToken()}`
    }

    if (editingId.value) {
      await api.put(
        `/medical-histories/${editingId.value}`,
        form,
        { headers }
      )

      showMessage('Medical history updated successfully!')
    } else {
      await api.post('/medical-histories', form, { headers })

      showMessage('Medical history saved successfully!')
    }

    resetForm()
    await loadHistories()

  } catch (error: any) {
    showMessage(
      error.response?.data?.message || 'Failed to save medical history.',
      'error'
    )
  } finally {
    loading.value = false
  }
}

function editHistory(history: any) {
  editingId.value = history.id

  Object.assign(form, {
    blood_group: history.blood_group || '',
    previous_diseases: history.previous_diseases || '',
    allergies: history.allergies || '',
    current_medications: history.current_medications || '',
    past_surgeries: history.past_surgeries || '',
    family_medical_history: history.family_medical_history || '',
    additional_notes: history.additional_notes || ''
  })

  window.scrollTo({ top: 0, behavior: 'smooth' })
}

async function deleteHistory(id: number) {
  if (!confirm('Are you sure you want to delete this medical history?')) {
    return
  }

  try {
    await api.delete(`/medical-histories/${id}`, {
      headers: {
        Authorization: `Bearer ${getToken()}`
      }
    })

    showMessage('Medical history deleted successfully!')
    await loadHistories()

  } catch (error: any) {
    showMessage(
      error.response?.data?.message || 'Failed to delete medical history.',
      'error'
    )
  }
}

function goDashboard() {
  router.push('/dashboard')
}

onMounted(() => {
  if (!getToken()) {
    router.push('/login')
    return
  }

  loadHistories()
})
</script>

<style scoped>
.medical-history-page {
  min-height: 100vh;
  background: #f3f8f8;
  padding: 40px 20px;
  font-family: Arial, sans-serif;
}

.container {
  max-width: 950px;
  margin: auto;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 15px;
  margin-bottom: 30px;
}

.header h1 {
  color: #087f80;
  margin: 0 0 8px;
}

.header p {
  color: #64748b;
}

.back-btn,
.save-btn {
  background: #078b89;
  color: white;
  border: none;
  padding: 12px 22px;
  border-radius: 7px;
  cursor: pointer;
}

.history-card {
  background: white;
  padding: 28px;
  border-radius: 12px;
  margin-bottom: 25px;
  box-shadow: 0 3px 15px rgba(0,0,0,0.05);
}

.history-card h2 {
  color: #087f80;
  margin-top: 0;
  margin-bottom: 25px;
}

.form-group {
  margin-bottom: 18px;
}

.form-group label {
  display: block;
  font-weight: 600;
  margin-bottom: 8px;
  color: #334155;
}

.form-group input,
.form-group select,
.form-group textarea {
  width: 100%;
  box-sizing: border-box;
  padding: 12px;
  border: 1px solid #cbd5e1;
  border-radius: 7px;
  font-size: 14px;
  outline: none;
}

.form-group textarea {
  min-height: 85px;
  resize: vertical;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  border-color: #078b89;
}

.form-buttons {
  display: flex;
  gap: 12px;
}

.save-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.cancel-btn,
.edit-btn,
.delete-btn {
  padding: 9px 15px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}

.cancel-btn {
  background: #64748b;
  color: white;
}

.edit-btn {
  background: #e0f2fe;
  color: #0369a1;
}

.delete-btn {
  background: #fee2e2;
  color: #dc2626;
}

.message {
  padding: 13px;
  border-radius: 7px;
  margin-bottom: 20px;
}

.message.success {
  background: #dcfce7;
  color: #166534;
}

.message.error {
  background: #fee2e2;
  color: #991b1b;
}

.record-item {
  border: 1px solid #e2e8f0;
  padding: 20px;
  border-radius: 9px;
  margin-bottom: 15px;
  overflow-wrap: anywhere;
}

.record-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 12px;
}

.record-header h3 {
  color: #087f80;
}

.record-item p {
  color: #475569;
  line-height: 1.6;
}

.record-actions {
  display: flex;
  gap: 8px;
}

@media (max-width: 600px) {
  .header,
  .record-header {
    flex-direction: column;
    align-items: flex-start;
  }

  .history-card {
    padding: 18px;
  }
}
</style>
