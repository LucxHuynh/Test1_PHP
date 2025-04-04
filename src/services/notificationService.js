import api from './api';
import authService from './authService';

const notificationService = {
  getNotifications: async () => {
    try {
      const token = authService.getToken();
      const userId = authService.getUserIdFromToken();
      
      // Nếu không có userId, sử dụng endpoint mặc định
      const endpoint = userId ? `/api/user/${userId}/notifications` : '/api/notifications';
      
      console.log('Fetching notifications from endpoint:', endpoint);
      
      const response = await api.get(endpoint, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      });
      return response.data;
    } catch (error) {
      console.error('Error fetching notifications:', error);
      return { success: false, data: [], message: 'Không thể tải thông báo' };
    }
  }
};

export default notificationService;
