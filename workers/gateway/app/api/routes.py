from fastapi import APIRouter
from app.domain.models import ModuleJobRequest, ModuleJobResult
from app.routing.module_router import ModuleRouter

router = APIRouter()

@router.post("/modules/{module_code}", response_model=ModuleJobResult)
def run_module_job(module_code: str, request: ModuleJobRequest):
    return ModuleRouter().route(module_code, request)