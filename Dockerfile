# ─── Stage 1: Build ───────────────────────────────────────────────────────────
FROM node:22-alpine AS builder

WORKDIR /app

# Copy only the frontend directory
COPY frontend/ ./frontend/

# Install dependencies and build the Vue.js app
WORKDIR /app/frontend
RUN npm install
RUN npm run build

# ─── Stage 2: Runtime ─────────────────────────────────────────────────────────
FROM nginx:stable-alpine AS runtime

# Remove the default Nginx config
RUN rm /etc/nginx/conf.d/default.conf

# Add a custom Nginx config for the Vue SPA
COPY nginx.conf /etc/nginx/conf.d/app.conf

# Copy the built assets from the builder stage
COPY --from=builder /app/frontend/dist /usr/share/nginx/html

EXPOSE 3000

CMD ["nginx", "-g", "daemon off;"]
