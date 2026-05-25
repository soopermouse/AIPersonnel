from fastapi import FastAPI
from app.api.routes import router

app = FastAPI(
    title="NXDOne Worker Gateway",
    description="Routes ERP module jobs to specialised AI/business workers.",
    version="0.1.0",
)

app.include_router(router, prefix="/api")

@app.get("/")
def health():
    return {"status": "ok", "service": "nxdone-worker-gateway"}