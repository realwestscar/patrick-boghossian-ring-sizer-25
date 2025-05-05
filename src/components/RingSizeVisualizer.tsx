
import React, { useState, useEffect, useRef } from 'react';
import { motion } from 'framer-motion';
import { Slider } from '@/components/ui/slider';
import { MoveIcon, ZoomInIcon, ZoomOutIcon } from 'lucide-react';
import RulerGuide from './RulerGuide';
import { useIsMobile } from '@/hooks/use-mobile';
import { useOrientation } from '@/hooks/use-orientation';

interface RingSizeVisualizerProps {
  unit: 'mm' | 'inches';
  measurementType: 'diameter' | 'circumference';
  onSizeChange: (sizeMm: number) => void;
}

// Ring size mapping for reference (diameter in millimeters)
const ringSizes = {
  usa: [
    { size: '3', diameterMm: 14.1 },
    { size: '3.5', diameterMm: 14.5 },
    { size: '4', diameterMm: 14.9 },
    { size: '4.5', diameterMm: 15.3 },
    { size: '5', diameterMm: 15.7 },
    { size: '5.5', diameterMm: 16.1 },
    { size: '6', diameterMm: 16.5 },
    { size: '6.5', diameterMm: 16.9 },
    { size: '7', diameterMm: 17.3 },
    { size: '7.5', diameterMm: 17.7 },
    { size: '8', diameterMm: 18.1 },
    { size: '8.5', diameterMm: 18.5 },
    { size: '9', diameterMm: 18.9 },
    { size: '9.5', diameterMm: 19.3 },
    { size: '10', diameterMm: 19.7 },
    { size: '10.5', diameterMm: 20.1 },
    { size: '11', diameterMm: 20.5 },
    { size: '11.5', diameterMm: 20.9 },
    { size: '12', diameterMm: 21.3 },
    { size: '12.5', diameterMm: 21.7 },
    { size: '13', diameterMm: 22.1 },
  ],
};

const RingSizeVisualizer: React.FC<RingSizeVisualizerProps> = ({ unit, measurementType, onSizeChange }) => {
  // Start with a reasonable default diameter
  const minDiameter = 14.0;
  const maxDiameter = 22.5;
  const [diameterMm, setDiameterMm] = useState(17.3); // US size 7 as default
  const [sliderValue, setSliderValue] = useState([(diameterMm - minDiameter) / (maxDiameter - minDiameter) * 100]);
  const [isDragging, setIsDragging] = useState(false);
  const [initialTouchDistance, setInitialTouchDistance] = useState<number | null>(null);
  const [initialDiameter, setInitialDiameter] = useState<number>(diameterMm);
  
  const containerRef = useRef<HTMLDivElement>(null);
  const circleRef = useRef<HTMLDivElement>(null);
  
  const isMobile = useIsMobile();
  const orientation = useOrientation();
  
  useEffect(() => {
    onSizeChange(diameterMm);
  }, [diameterMm, onSizeChange]);

  // Calculate circumference from diameter
  const circumference = diameterMm * Math.PI;
  
  // Convert measurement based on unit type
  const displayMeasurement = unit === 'mm' 
    ? measurementType === 'diameter' 
      ? diameterMm.toFixed(2) 
      : circumference.toFixed(2)
    : measurementType === 'diameter'
      ? (diameterMm / 25.4).toFixed(3)
      : (circumference / 25.4).toFixed(3);

  const handleSliderChange = (value: number[]) => {
    setSliderValue(value);
    const newDiameter = minDiameter + (value[0] / 100) * (maxDiameter - minDiameter);
    setDiameterMm(newDiameter);
    triggerHapticFeedback();
  };

  // Touch/mouse event handlers for direct size manipulation
  const handlePointerDown = (e: React.PointerEvent) => {
    if (circleRef.current && containerRef.current) {
      e.preventDefault();
      setIsDragging(true);
    }
  };

  const handlePointerMove = (e: React.PointerEvent) => {
    if (isDragging && circleRef.current && containerRef.current) {
      const containerRect = containerRef.current.getBoundingClientRect();
      const centerX = containerRect.left + containerRect.width / 2;
      const centerY = containerRect.top + containerRect.height / 2;
      
      // Calculate distance from center to pointer
      const dx = e.clientX - centerX;
      const dy = e.clientY - centerY;
      const distance = Math.sqrt(dx * dx + dy * dy);
      
      // Convert distance in pixels to diameter in mm
      // This is a simplified conversion - in a real app, would use calibration
      const containerSize = Math.min(containerRect.width, containerRect.height);
      const maxVisualDiameter = containerSize * 0.9; // Max pixel diameter for ring visual
      
      const ratio = distance / (maxVisualDiameter / 2); // Dividing by 2 to get radius ratio
      const newDiameterMm = Math.min(Math.max(minDiameter, ratio * maxDiameter), maxDiameter);
      
      setDiameterMm(newDiameterMm);
      setSliderValue([(newDiameterMm - minDiameter) / (maxDiameter - minDiameter) * 100]);
    }
  };

  const handlePointerUp = () => {
    setIsDragging(false);
    triggerHapticFeedback();
  };

  // Pinch to zoom gesture handling
  const handleTouchStart = (e: React.TouchEvent) => {
    if (e.touches.length === 2) {
      // Calculate initial distance between two touch points
      const dx = e.touches[0].clientX - e.touches[1].clientX;
      const dy = e.touches[0].clientY - e.touches[1].clientY;
      const distance = Math.sqrt(dx * dx + dy * dy);
      
      setInitialTouchDistance(distance);
      setInitialDiameter(diameterMm);
    }
  };

  const handleTouchMove = (e: React.TouchEvent) => {
    if (initialTouchDistance && e.touches.length === 2) {
      // Calculate current distance between touch points
      const dx = e.touches[0].clientX - e.touches[1].clientX;
      const dy = e.touches[0].clientY - e.touches[1].clientY;
      const currentDistance = Math.sqrt(dx * dx + dy * dy);
      
      // Calculate scale factor based on change in touch distance
      const scaleFactor = currentDistance / initialTouchDistance;
      
      // Apply scale factor to initial diameter
      const newDiameterMm = Math.min(Math.max(minDiameter, initialDiameter * scaleFactor), maxDiameter);
      
      setDiameterMm(newDiameterMm);
      setSliderValue([(newDiameterMm - minDiameter) / (maxDiameter - minDiameter) * 100]);
    }
  };

  const handleTouchEnd = () => {
    setInitialTouchDistance(null);
    triggerHapticFeedback();
  };

  // Trigger haptic feedback on mobile devices
  const triggerHapticFeedback = () => {
    if (isMobile && window.navigator.vibrate) {
      window.navigator.vibrate(20); // Vibrate for 20ms
    }
  };

  // Calculate visual size scaling based on orientation and device size
  const getVisualDiameter = () => {
    if (!containerRef.current) return 220;
    
    const containerSize = Math.min(
      containerRef.current.offsetWidth,
      containerRef.current.offsetHeight
    );
    
    // Adjust based on orientation
    const orientationFactor = orientation === 'landscape' ? 0.7 : 0.8;
    const maxVisualDiameter = containerSize * orientationFactor;
    
    const scale = diameterMm / maxDiameter;
    return maxVisualDiameter * scale;
  };
  
  const visualDiameter = getVisualDiameter();

  return (
    <motion.div 
      className={`w-full max-w-3xl mx-auto p-4 ${
        orientation === 'landscape' ? 'flex flex-row items-center justify-center gap-4' : 'flex flex-col'
      }`}
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      transition={{ duration: 0.8 }}
    >
      <div 
        ref={containerRef}
        className={`relative ${
          orientation === 'landscape' 
            ? 'w-2/3 aspect-square' 
            : 'w-full aspect-square mb-8'
        } flex items-center justify-center overflow-hidden`}
        onPointerDown={handlePointerDown}
        onPointerMove={handlePointerMove}
        onPointerUp={handlePointerUp}
        onPointerLeave={handlePointerUp}
        onTouchStart={handleTouchStart}
        onTouchMove={handleTouchMove}
        onTouchEnd={handleTouchEnd}
        style={{
          touchAction: 'none' // Prevents browser handling of touch events
        }}
      >
        {/* Background grid pattern */}
        <div className="absolute inset-0 bg-grid opacity-10"></div>

        {/* Ruler guide */}
        <RulerGuide 
          diameterMm={diameterMm} 
          visualDiameter={visualDiameter} 
          unit={unit}
        />

        {/* Ring visualization */}
        <motion.div 
          ref={circleRef}
          className={`ring-circle ${isDragging ? 'cursor-grabbing' : 'cursor-grab'}`}
          style={{ 
            width: `${visualDiameter}px`, 
            height: `${visualDiameter}px`,
          }}
          animate={{ 
            width: `${visualDiameter}px`, 
            height: `${visualDiameter}px` 
          }}
          transition={{ type: "spring", stiffness: 300, damping: 25 }}
        >
          <div className="ring-indicator animate-pulse-ring"></div>
          
          {/* Measurement display */}
          <motion.div 
            className="absolute inset-0 flex items-center justify-center flex-col"
            animate={{ scale: [0.95, 1.05, 1] }}
            transition={{ duration: 0.5 }}
          >
            <span className="font-display text-2xl font-medium text-burgundy">
              {displayMeasurement} {unit}
            </span>
            <span className="text-xs uppercase tracking-wider text-burgundy/70">
              {measurementType}
            </span>
          </motion.div>

          {/* Drag handles for visual feedback */}
          {isMobile && (
            <>
              <div className="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-gold rounded-full w-6 h-6 flex items-center justify-center shadow-md border-2 border-white">
                <ZoomInIcon size={16} className="text-burgundy" />
              </div>
              <div className="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 bg-gold rounded-full w-6 h-6 flex items-center justify-center shadow-md border-2 border-white">
                <ZoomOutIcon size={16} className="text-burgundy" />
              </div>
              <div className="absolute left-0 top-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-gold rounded-full w-6 h-6 flex items-center justify-center shadow-md border-2 border-white">
                <MoveIcon size={16} className="text-burgundy" />
              </div>
              <div className="absolute right-0 top-1/2 transform translate-x-1/2 -translate-y-1/2 bg-gold rounded-full w-6 h-6 flex items-center justify-center shadow-md border-2 border-white">
                <MoveIcon size={16} className="text-burgundy" />
              </div>
            </>
          )}
        </motion.div>
        
        {/* Dimension arrows */}
        {measurementType === 'diameter' && (
          <>
            <div className="absolute left-0 right-0 h-px bg-burgundy/30 z-10 flex items-center justify-between px-2">
              <div className="h-2 w-2 rounded-full bg-burgundy"></div>
              <div className="h-2 w-2 rounded-full bg-burgundy"></div>
            </div>
            <div className="absolute top-0 bottom-0 w-px bg-burgundy/30 z-10 flex flex-col items-center justify-between py-2">
              <div className="h-2 w-2 rounded-full bg-burgundy"></div>
              <div className="h-2 w-2 rounded-full bg-burgundy"></div>
            </div>
          </>
        )}
      </div>

      {/* Size slider control - position adjusts based on orientation */}
      <div className={`px-6 ${orientation === 'landscape' ? 'w-1/3' : 'mb-8'}`}>
        <Slider 
          value={sliderValue} 
          onValueChange={handleSliderChange} 
          max={100} 
          step={0.1}
          className="ring-slider"
          orientation={orientation === 'landscape' ? 'vertical' : 'horizontal'}
        />
        
        {/* Touch instructions */}
        <motion.div 
          className="text-center text-sm text-burgundy/80 mt-4 glassmorphism p-4 rounded-lg mx-auto"
          initial={{ opacity: 0, y: 10 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ delay: 0.5 }}
        >
          {isMobile ? (
            <p>Touch and drag the circle or pinch to zoom for precise sizing</p>
          ) : (
            <p>Click and drag the circle for precise sizing</p>
          )}
        </motion.div>
      </div>
    </motion.div>
  );
};

export default RingSizeVisualizer;
