
import React, { useState, useRef, useEffect } from 'react';
import { motion } from 'framer-motion';
import { CreditCard, Check, Info } from 'lucide-react';
import { toast } from 'sonner';

interface DeviceCalibrationProps {
  onCalibrate: (calibrationFactor: number) => void;
  isCalibrated: boolean;
  onReset: () => void;
}

// Standard credit card width in mm
const CREDIT_CARD_WIDTH_MM = 85.60;

const DeviceCalibration: React.FC<DeviceCalibrationProps> = ({ onCalibrate, isCalibrated, onReset }) => {
  const [isCalibrating, setIsCalibrating] = useState(false);
  const [cardWidth, setCardWidth] = useState(0);
  const cardRef = useRef<HTMLDivElement>(null);
  
  const handleResize = () => {
    if (cardRef.current && isCalibrating) {
      setCardWidth(cardRef.current.clientWidth);
    }
  };

  useEffect(() => {
    window.addEventListener('resize', handleResize);
    return () => window.removeEventListener('resize', handleResize);
  }, [isCalibrating]);

  useEffect(() => {
    if (isCalibrating && cardRef.current) {
      setCardWidth(cardRef.current.clientWidth);
    }
  }, [isCalibrating]);

  const startCalibration = () => {
    setIsCalibrating(true);
    toast("Starting calibration", {
      description: "Place a credit card on the outline to calibrate the display",
    });
  };

  const completeCalibration = () => {
    if (cardWidth > 0) {
      // Calculate pixels per mm
      const pixelsPerMm = cardWidth / CREDIT_CARD_WIDTH_MM;
      onCalibrate(pixelsPerMm);
      setIsCalibrating(false);
      toast("Calibration complete", {
        description: "Your device is now calibrated for accurate measurements",
        icon: <Check className="text-green-500" />
      });
    }
  };

  if (isCalibrated && !isCalibrating) {
    return (
      <div className="text-center mb-6">
        <p className="text-sm text-burgundy/80 flex items-center justify-center gap-2">
          <Check size={16} className="text-green-500" />
          <span>Device calibrated for accurate size display</span>
        </p>
        <button 
          onClick={onReset} 
          className="text-xs text-burgundy underline mt-1 hover:text-burgundy-light"
        >
          Recalibrate
        </button>
      </div>
    );
  }

  return (
    <motion.div 
      className="mb-8 text-center"
      initial={{ opacity: 0, y: 20 }}
      animate={{ opacity: 1, y: 0 }}
      transition={{ duration: 0.5 }}
    >
      {!isCalibrating ? (
        <div className="flex flex-col items-center">
          <motion.button
            className="gold-button px-4 py-2 rounded-md flex items-center gap-2 mb-2"
            onClick={startCalibration}
            whileHover={{ scale: 1.03 }}
            whileTap={{ scale: 0.98 }}
          >
            <CreditCard size={16} />
            <span>Calibrate for Accurate Size</span>
          </motion.button>
          <p className="text-sm text-burgundy/80 flex items-center gap-1">
            <Info size={14} />
            <span>For true-to-life measurements on your device</span>
          </p>
        </div>
      ) : (
        <div className="flex flex-col items-center">
          <p className="text-sm text-burgundy mb-4">
            Place a real credit card on the outline below
          </p>
          <div className="relative mb-6">
            <motion.div 
              ref={cardRef}
              className="credit-card-outline border-2 border-dashed border-burgundy rounded-lg"
              style={{ 
                width: '85%', 
                height: '53.98mm',
                maxWidth: '400px'
              }}
              initial={{ borderColor: 'rgba(90, 14, 37, 0.6)' }}
              animate={{ 
                borderColor: ['rgba(90, 14, 37, 0.6)', 'rgba(212, 175, 55, 0.9)', 'rgba(90, 14, 37, 0.6)'],
              }}
              transition={{ 
                duration: 2,
                repeat: Infinity,
              }}
            >
              <div className="absolute inset-0 flex items-center justify-center text-burgundy/30">
                <CreditCard size={40} />
              </div>
            </motion.div>
          </div>
          <motion.button
            className="burgundy-button px-4 py-2 rounded-md flex items-center gap-2"
            onClick={completeCalibration}
            whileHover={{ scale: 1.03 }}
            whileTap={{ scale: 0.98 }}
          >
            <Check size={16} />
            <span>Confirm Calibration</span>
          </motion.button>
        </div>
      )}
    </motion.div>
  );
};

export default DeviceCalibration;
