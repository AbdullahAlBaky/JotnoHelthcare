# Flask ML service

Loads the supplied `models/jotnohealthcare_general_disease_model.pkl` using joblib. Install the pinned requirements because the artifact records scikit-learn 1.6.1. Start with `python app.py`.

- `GET /health`
- `POST /predict` JSON: `{"symptoms":["itching","skin_rash"]}`

The model has 41 classes and 131 symptom features. The saved training metrics are 1.0, but the source dataset is template-like and the unique-combination count is small. Do not interpret the metrics as clinical validity. This service is for academic demonstration only.
