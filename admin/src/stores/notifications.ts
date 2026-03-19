import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import axios from '../api/axios'

export interface Notification {
  id: string
  type: string
  title: string
  message: string
  time: string
  timestamp: string
  read: boolean
  link: string
  icon: string
  color: string
}

export const useNotificationsStore = defineStore('notifications', () => {
  const notifications = ref<Notification[]>([])
  const unreadCount = ref(0)
  const loading = ref(false)
  const lastFetch = ref<Date | null>(null)

  const hasUnread = computed(() => unreadCount.value > 0)

  const fetchNotifications = async () => {
    loading.value = true
    try {
      const response = await axios.get('/notifications')
      notifications.value = response.data.data
      unreadCount.value = response.data.meta.unread
      lastFetch.value = new Date()
    } catch (error) {
      console.error('Failed to fetch notifications:', error)
    } finally {
      loading.value = false
    }
  }

  const fetchCounts = async () => {
    try {
      const response = await axios.get('/notifications/counts')
      unreadCount.value = response.data.data.total
    } catch (error) {
      console.error('Failed to fetch notification counts:', error)
    }
  }

  const markAsRead = (notificationId: string) => {
    const notification = notifications.value.find(n => n.id === notificationId)
    if (notification && !notification.read) {
      notification.read = true
      unreadCount.value = Math.max(0, unreadCount.value - 1)
    }
  }

  const markAllAsRead = () => {
    notifications.value.forEach(n => n.read = true)
    unreadCount.value = 0
  }

  return {
    notifications,
    unreadCount,
    loading,
    lastFetch,
    hasUnread,
    fetchNotifications,
    fetchCounts,
    markAsRead,
    markAllAsRead
  }
})
