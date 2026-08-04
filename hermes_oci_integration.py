import os
import json
import oci

def upload_to_oci_object_storage(file_path: str, bucket_name: str, namespace: str):
    """
    Agent: @backend-specialist
    Purpose: Automatically upload the Hermes scraper results to the 10GB free OCI Object Storage.
    This prevents data loss and allows easy downloads without SSH.
    """
    config = oci.config.from_file() # Requires ~/.oci/config to be set up on the VPS
    object_storage = oci.object_storage.ObjectStorageClient(config)
    
    file_name = os.path.basename(file_path)
    print(f"[HERMES] Uploading {file_name} to OCI Free Tier Object Storage...")
    
    with open(file_path, 'rb') as f:
        object_storage.put_object(
            namespace,
            bucket_name,
            file_name,
            f
        )
    print(f"[HERMES] Upload Complete. {file_name} is safely stored in the cloud.")

def get_secret_from_oci_vault(secret_ocid: str) -> str:
    """
    Agent: @security-auditor
    Purpose: Retrieve API keys (like Cloudflare Worker tokens) from OCI Vault 
    so they aren't hardcoded in the script. (150 free secrets allowed).
    """
    config = oci.config.from_file()
    secrets_client = oci.secrets.SecretsClient(config)
    
    response = secrets_client.get_secret_bundle(secret_ocid)
    # The secret is Base64 encoded by Oracle, the SDK handles the bundle
    # We must decode the base64 content
    import base64
    secret_content = response.data.secret_bundle_content.content
    return base64.b64decode(secret_content).decode("utf-8")

if __name__ == "__main__":
    # Example Hermes deterministic output
    hermes_output = {
        "status": "success",
        "records_extracted": 1500,
        "database": "Local Docker Postgres",
        "backup": "OCI Object Storage",
    }
    
    # 1. Output strict JSON for Hermes
    print(json.dumps(hermes_output))
