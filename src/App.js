// filepath: d:\React\hr-erp-frontend\src\App.js
import React, { useEffect } from "react";
import {
  BrowserRouter as Router,
  Route,
  Routes,
  Navigate,
} from "react-router-dom";
import Login from "./components/Login";
import Dashboard from "./pages/Dashboard";
import AllEmployees from "./pages/AllEmployee";
import UserProfilePage from "./pages/UserProfilePage";
import Project from "./pages/Project";
import MyTasksPage from "../src/pages/MyTasksPage";
import Forbiden from "./components/common/Forbiden";
import authService from "./services/authService";
import LeaveRequestPage from "./pages/LeaveRequestPage";
import LeaveApprovalPage from "./pages/LeaveApprovalPage";
import AttendancePage from "./pages/Attendance";
import PayrollPage from "./pages/PayrollPage";
import ChatBox from './components/ChatBox';


function App() {
  // Debug: Log user info to check if role is correctly saved
  useEffect(() => {
    const userStr = localStorage.getItem("user");
    if (userStr) {
      try {
        const userData = JSON.parse(userStr);
        console.log("Current user data:", userData);

        // Kiểm tra cấu trúc dữ liệu để xác định vai trò
        const role = userData.user?.role || userData.role;
        console.log("Detected user role:", role);
        console.log(
          "Is admin or manager check:",
          role === "Admin" || role === "Manager"
        );
      } catch (error) {
        console.error("Error parsing user data:", error);
      }
    } else {
      console.log("No user data in localStorage");
    }
  }, []);

  const isAuthenticated = () => {
    const isAuth = !!localStorage.getItem("user");
    console.log("isAuthenticated check result:", isAuth);
    return isAuth;
  };

  const hasRole = (role) => {
    try {
      const userData = JSON.parse(localStorage.getItem("user") || "{}");
      
      // Cấu trúc dữ liệu có thể khác nhau
      let userRole = null;
      
      // Kiểm tra các cấu trúc có thể: { user: { role } }, { role }
      if (userData.user && userData.user.role) {
        userRole = userData.user.role;
      } else if (userData.role) {
        userRole = userData.role;
      }
      
      // Chuyển về chữ thường để so sánh không phân biệt hoa thường
      const normalizedUserRole = userRole ? userRole.toLowerCase() : '';
      const normalizedRole = role.toLowerCase();
      
      const hasRoleResult = normalizedUserRole === normalizedRole;
      console.log(
        `hasRole('${role}') check result:`,
        hasRoleResult,
        "Detected role:",
        userRole
      );
      return hasRoleResult;
    } catch (error) {
      console.error("Error in hasRole:", error);
      return false;
    }
  };

  // const isAdminOrManager = () => {
  //   try {
  //     const userData = JSON.parse(localStorage.getItem("user") || "{}");
  //     // Cấu trúc có thể là { role } hoặc { user: { role } }
  //     const userRole = userData.user?.role || userData.role;
  //     const isAdminManagerResult =
  //       userRole === "Admin" || userRole === "Manager";
  //     console.log(
  //       "isAdminOrManager check result:",
  //       isAdminManagerResult,
  //       "Detected role:",
  //       userRole
  //     );
  //     return isAdminManagerResult;
  //   } catch (error) {
  //     console.error("Error in isAdminOrManager:", error);
  //     return false;
  //   }
  // };
  
  const isAdminOrAccountant = () => {
    try {
      const userData = JSON.parse(localStorage.getItem("user") || "{}");
      
      // Cấu trúc dữ liệu có thể khác nhau
      let userRole = null;
      
      // Kiểm tra các cấu trúc có thể: { user: { role } }, { role }
      if (userData.user && userData.user.role) {
        userRole = userData.user.role;
      } else if (userData.role) {
        userRole = userData.role;
      }
      
      // Chuyển về chữ thường để so sánh không phân biệt hoa thường
      const normalizedUserRole = userRole ? userRole.toLowerCase() : '';
      
      return normalizedUserRole === "admin" || normalizedUserRole === "accountant";
    } catch (error) {
      console.error("Error in isAdminOrAccountant:", error);
      return false;
    }
  };

  const isAdminOrManager = () => {
    try {
      const userData = JSON.parse(localStorage.getItem("user") || "{}");
      
      // Cấu trúc dữ liệu có thể khác nhau
      let userRole = null;
      
      // Kiểm tra các cấu trúc có thể: { user: { role } }, { role }
      if (userData.user && userData.user.role) {
        userRole = userData.user.role;
      } else if (userData.role) {
        userRole = userData.role;
      }
      
      // Chuyển về chữ thường để so sánh không phân biệt hoa thường
      const normalizedUserRole = userRole ? userRole.toLowerCase() : '';
      
      const isAdminManagerResult =
        normalizedUserRole === "admin" || normalizedUserRole === "manager";
        
      console.log(
        "isAdminOrManager check result:",
        isAdminManagerResult,
        "Detected role:",
        userRole
      );
      return isAdminManagerResult;
    } catch (error) {
      console.error("Error in isAdminOrManager:", error);
      return false;
    }
  };

  return (
    <Router>
      <div className="App">
        <Routes>
          <Route path="/login" element={<Login />} />
          <Route
            path="/dashboard"
            element={
              isAuthenticated() ? <Dashboard /> : <Navigate to="/login" />
            }
          />
          <Route
            path="/my-tasks"
            element={
              isAuthenticated() ? <MyTasksPage /> : <Navigate to="/login" />
            }
          />
          <Route
            path="/employees"
            element={
              isAuthenticated() ? <AllEmployees /> : <Navigate to="/login" />
            }
          />
          <Route
            path="/leave-request"
            element={
              isAuthenticated() ? (
                <LeaveRequestPage />
              ) : (
                <Navigate to="/login" />
              )
            }
          />
          <Route
            path="/leave-approval"
            element={
              isAuthenticated() && isAdminOrManager() ? (
                <LeaveApprovalPage />
              ) : (
                <Navigate to="/dashboard" />
              )
            }
          />
          <Route
            path="/"
            element={
              <Navigate to={isAuthenticated() ? "/dashboard" : "/login"} />
            }
          />
          <Route
            path="/projects/*"
            element={
              isAuthenticated() ? (
                <Project />
              ) : (
                <Navigate to="/login" />
              )
            }
          />
          <Route
            path="/leave-approval"
            element={
              isAuthenticated() && isAdminOrManager() ? (
                <LeaveApprovalPage />
              ) : (
                <Navigate to="/dashboard" />
              )
            }
          />
          <Route
            path="/payroll"
            element={
              isAuthenticated() ? (
                <PayrollPage />
              ) : (
                <Navigate to="/login" />
              )
            }
          />
          <Route
            path="/profile"
            element={
              isAuthenticated() ? (
                <UserProfilePage />
              ) : (
                <Navigate to="/login" />
              )
            }
          />
          <Route
            path="/profile/:id"
            element={
              isAuthenticated() ? (
                <UserProfilePage />
              ) : (
                <Navigate to="/login" />
              )
            }
          />
          <Route
            path="/attendance"
            element={
              isAuthenticated() ? <AttendancePage /> : <Navigate to="/login" />
            }
          />
          <Route path="*" element={<Navigate to="/" />} />
        </Routes>
        <ChatBox />
      </div>
    </Router>
  );
}

export default App;