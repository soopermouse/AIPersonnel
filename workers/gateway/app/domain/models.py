from pydantic import BaseModel, Field
from typing import Any


class ModuleJobRequest(BaseModel):
    job_type: str
    payload: dict[str, Any] = Field(default_factory=dict)


class ModuleJobResult(BaseModel):
    module_code: str
    job_type: str
    status: str
    result: dict[str, Any] = Field(default_factory=dict)
    warnings: list[str] = Field(default_factory=list)