from flask import Flask, request, jsonify
from pathlib import Path
import joblib

app = Flask(__name__)
MODEL_PATH = Path(__file__).parent / "models" / "jotnohealthcare_general_disease_model.pkl"
artifact = joblib.load(MODEL_PATH)
model = artifact["model"]
binarizer = artifact["binarizer"]
feature_names = set(artifact.get("feature_names", []))

# Suggestions are simple routing hints for the prototype, not clinical advice.
DEPARTMENT_HINTS = {
    "heart": "Cardiology", "diabetes": "Endocrinology", "asthma": "Respiratory Medicine",
    "hepatitis": "Gastroenterology", "migraine": "Neurology", "arthritis": "Rheumatology",
    "fungal": "Dermatology", "acne": "Dermatology", "allergy": "Allergy and Immunology",
}
def department_for(label: str) -> str:
    low = label.lower()
    for key, value in DEPARTMENT_HINTS.items():
        if key in low: return value
    return "General Medicine"

@app.get("/health")
def health():
    return jsonify({"status":"ok", "model":"RandomForestClassifier", "disease_classes":len(model.classes_), "symptom_features":len(binarizer.classes_)})

@app.post("/predict")
def predict():
    body = request.get_json(silent=True) or {}
    symptoms = body.get("symptoms")
    if not isinstance(symptoms, list) or not symptoms or not all(isinstance(x, str) for x in symptoms):
        return jsonify({"error":"symptoms must be a non-empty list of strings"}), 422
    normalized = [s.strip().lower().replace(" ", "_") for s in symptoms if s.strip()]
    if not normalized: return jsonify({"error":"No valid symptoms provided"}), 422
    unknown = [s for s in normalized if s not in feature_names]
    if unknown: return jsonify({"error":"Unknown symptom feature(s)","unknown_symptoms":unknown,"accepted_symptoms":sorted(feature_names)}), 422
    vector = binarizer.transform([normalized])
    prediction = str(model.predict(vector)[0])
    return jsonify({"prediction":prediction,"suggested_department":department_for(prediction),"model_name":artifact.get("model_name","RandomForestClassifier"),"notice":"Preliminary dataset-based suggestion only. Not a diagnosis, triage, or treatment recommendation. A qualified doctor must review."})

if __name__ == "__main__": app.run(host="127.0.0.1", port=5001, debug=False)
