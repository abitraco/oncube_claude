# 🚀 Deploy ONCUBE GLOBAL to Render

## Prerequisites
- ✅ GitHub repository: `https://github.com/abitraco/oncube_claude.git`
- ✅ Dockerfile configured
- ✅ render.yaml configured

## Step-by-Step Deployment Guide

### 1. Sign Up / Log In to Render
1. Go to [https://render.com](https://render.com)
2. Sign up or log in (use GitHub account for easier integration)

### 2. Connect Your GitHub Repository

#### Option A: Deploy via Blueprint (Recommended - Uses render.yaml)
1. From Render Dashboard, click **"New"** → **"Blueprint"**
2. Connect your GitHub account if not already connected
3. Search and select repository: `abitraco/oncube_claude`
4. Render will automatically detect `render.yaml`
5. Click **"Apply"**
6. Render will create the service based on the configuration

#### Option B: Manual Deployment
1. From Render Dashboard, click **"New"** → **"Web Service"**
2. Connect your GitHub account if not already connected
3. Search and select repository: `abitraco/oncube_claude`
4. Configure the service:
   - **Name**: `oncube-global`
   - **Region**: Singapore (or closest to your users)
   - **Branch**: `main`
   - **Runtime**: Docker
   - **Dockerfile Path**: `./Dockerfile`
   - **Plan**: Free (or upgrade as needed)

### 3. Configure Environment Variables

Render will auto-generate `APP_KEY`, but you need to add eBay credentials:

**Required Environment Variables:**
```
APP_NAME=ONCUBE GLOBAL
APP_ENV=production
APP_DEBUG=false
APP_URL=https://oncube-global.onrender.com
APP_KEY=base64:xxxx (auto-generated)
LOG_CHANNEL=stack
LOG_LEVEL=error
DB_CONNECTION=sqlite
SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync

# eBay API Credentials (use your actual credentials from .env file)
EBAY_CLIENT_ID=your_ebay_client_id
EBAY_CLIENT_SECRET=your_ebay_client_secret
EBAY_LEGACY_APP_ID=your_ebay_legacy_app_id
```

**How to add:**
1. Go to your service in Render Dashboard
2. Click **"Environment"** tab
3. Add the eBay credentials from your `.env` file:
   - `EBAY_CLIENT_ID` (find in your local .env file)
   - `EBAY_CLIENT_SECRET` (find in your local .env file)
   - `EBAY_LEGACY_APP_ID` (find in your local .env file)
4. Click **"Save Changes"**

### 4. Deploy!

- If using Blueprint: Deployment starts automatically
- If manual: Click **"Create Web Service"**
- Wait for build to complete (5-10 minutes for first deploy)
- Monitor logs in the **"Logs"** tab

### 5. Access Your Application

Once deployed, your app will be available at:
**https://oncube-global.onrender.com**

### 6. Verify Deployment

Check these URLs:
- Homepage: `https://oncube-global.onrender.com/en/home`
- Shop: `https://oncube-global.onrender.com/en/shop`
- Health Check: `https://oncube-global.onrender.com/health`

---

## 🔧 Troubleshooting

### Issue: "Application Error" or 500 Error
**Solution:**
1. Check logs in Render Dashboard → Logs tab
2. Verify all environment variables are set correctly
3. Make sure `APP_KEY` is generated (should start with `base64:`)

### Issue: eBay API not working
**Solution:**
1. Verify eBay credentials in Environment Variables
2. Check eBay API rate limits
3. View logs for specific error messages

### Issue: CSS/JS files not loading
**Solution:**
1. Make sure files are in `/public` directory
2. Check asset URLs in blade templates use `asset()` helper
3. Clear browser cache

### Issue: Slow cold start (Free plan)
**Solution:**
- Free tier spins down after 15 minutes of inactivity
- First request after spin-down takes ~30-60 seconds
- Upgrade to paid plan for always-on service

---

## 🔄 Updating Your Application

### After making code changes:

1. **Commit changes:**
   ```powershell
   git add .
   git commit -m "Your commit message"
   git push origin main
   ```

2. **Auto-deploy:**
   - Render automatically detects changes and redeploys
   - Monitor deployment in Render Dashboard → Logs

3. **Manual deploy:**
   - Go to Render Dashboard → Your Service
   - Click **"Manual Deploy"** → **"Deploy latest commit"**

---

## 📊 Monitoring

### View Logs
1. Go to Render Dashboard
2. Select your service
3. Click **"Logs"** tab
4. Watch real-time logs

### View Metrics (Paid plans)
1. Go to **"Metrics"** tab
2. View CPU, Memory, Response times

---

## 💰 Pricing

**Free Plan (Current):**
- ✅ 750 hours/month
- ✅ Auto sleep after 15 min inactivity
- ✅ Shared CPU
- ✅ 512 MB RAM
- ⚠️ Slow cold starts

**Starter Plan ($7/month):**
- ✅ Always on (no sleep)
- ✅ 0.5 CPU
- ✅ 512 MB RAM
- ✅ Fast response times

**Standard Plan ($25/month):**
- ✅ 1 CPU
- ✅ 2 GB RAM
- ✅ Better performance

---

## 🌐 Custom Domain (Optional)

### To use your own domain:

1. Buy a domain (e.g., from Namecheap, Google Domains)
2. In Render Dashboard → Your Service → **"Settings"**
3. Click **"Custom Domain"**
4. Add your domain (e.g., `oncubeglobal.com`)
5. Follow DNS configuration instructions
6. Update `APP_URL` environment variable to your custom domain

---

## 📝 Important Notes

✅ **SQLite Database:**
- Stored in `/app/database/database.sqlite`
- Persists between deployments
- Backed up by Render

✅ **File Storage:**
- Uploaded files stored in `/app/storage`
- Persists between deployments

✅ **SSL/HTTPS:**
- Automatically provided by Render
- Free SSL certificate included

✅ **Performance:**
- First load after sleep: ~30-60 seconds (Free plan)
- Regular requests: Fast once warmed up
- Consider paid plan for production use

---

## 🆘 Support

### Render Support:
- Documentation: https://render.com/docs
- Community: https://community.render.com
- Email: support@render.com

### Application Issues:
- Check Laravel logs in Render Dashboard
- Review GitHub Issues: https://github.com/abitraco/oncube_claude/issues

---

## ✅ Deployment Checklist

Before going live:

- [ ] All environment variables configured
- [ ] eBay API credentials added
- [ ] Test all pages (Home, Shop, About, Contact)
- [ ] Test language switching (EN, KO, JA, ZH)
- [ ] Test product search functionality
- [ ] Test mobile responsive design
- [ ] Set up custom domain (optional)
- [ ] Enable monitoring/alerts
- [ ] Set up error tracking (Sentry, etc.) - optional

---

## 🎉 You're Ready to Deploy!

Follow the steps above and your ONCUBE GLOBAL B2B platform will be live on the internet! 🚀
