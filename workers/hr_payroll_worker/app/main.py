from fastapi import FastAPI
from app.api.routes import router

app = FastAPI(title="NXDOne HR Payroll Worker", version="0.1.0")
app.include_router(router, prefix="/api")

@app.get("/")
def health():
    return {"status": "ok", "service": "nxdone-hr-payroll-worker"}