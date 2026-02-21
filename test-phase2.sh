#!/bin/bash

# Test script for Phase 2 validation

BASE_URL="http://127.0.0.1:8000"
TEACHER_EMAIL="teacher@example.com"
TEACHER_PASS="password"

echo "Testing Phase 2 - Teacher Courses & Course Detail Page"
echo "========================================================"
echo ""

# Test 1: Guest Homepage
echo "Test 1: Loading homepage (guest view)..."
curl -s -o /dev/null -w "Status: %{http_code}\n" "$BASE_URL/"
echo ""

# Test 2: Course Catalog
echo "Test 2: Loading course catalog..."
curl -s -o /dev/null -w "Status: %{http_code}\n" "$BASE_URL/catalog"
echo ""

# Test 3: Course Detail Page
echo "Test 3: Loading course detail page..."
curl -s -o /dev/null -w "Status: %{http_code}\n" "$BASE_URL/courses/1"
echo ""

# Test 4: Teacher Dashboard (protected route)
echo "Test 4: Accessing teacher dashboard without auth..."
curl -s -o /dev/null -w "Status: %{http_code}\n" "$BASE_URL/teacher/dashboard"
echo ""

echo "Testing with authentication..."
# Get CSRF token from login page
CSRF=$(curl -s "$BASE_URL/login" | grep -oP 'name="_token" value="\K[^"]+')

# Login as teacher
echo ""
echo "Test 5: Logging in as teacher..."
curl -s -c /tmp/cookies.txt -b /tmp/cookies.txt \
  -X POST "$BASE_URL/login" \
  -d "_token=$CSRF&email=$TEACHER_EMAIL&password=$TEACHER_PASS" \
  -o /dev/null -w "Status: %{http_code}\n"

# Test 6: Teacher Dashboard (after auth)
echo ""
echo "Test 6: Accessing teacher dashboard (authenticated)..."
curl -s -b /tmp/cookies.txt -o /dev/null -w "Status: %{http_code}\n" "$BASE_URL/teacher/dashboard"
echo ""

# Test 7: Teacher Create Course
echo "Test 7: Accessing course create page..."
curl -s -b /tmp/cookies.txt -o /dev/null -w "Status: %{http_code}\n" "$BASE_URL/teacher/course/create"
echo ""

# Test 8: Teacher Lessons
echo "Test 8: Accessing lessons management page..."
curl -s -b /tmp/cookies.txt -o /dev/null -w "Status: %{http_code}\n" "$BASE_URL/teacher/course/1/lessons"
echo ""

echo ""
echo "All tests completed!"
