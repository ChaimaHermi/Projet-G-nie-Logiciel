/***********************************************************************
 * Module:  Facility.java
 * Author:  ayeta
 * Purpose: Defines the Class Facility
 ***********************************************************************/

import java.util.*;

/** @pdOid 45d23f20-01fb-46b8-aac1-52529dcaedf7 */
public class Facility {
   /** @pdOid 769203e6-a1e6-41c4-86ac-3236ad666fb6 */
   private String name;
   /** @pdOid cb6e0d1f-3dda-43b8-abb4-a6d712f7cf36 */
   private String description;
   /** @pdOid 7db65b6a-e8c6-4d55-ad08-a6e2561c8d74 */
   private String reference;
   /** @pdOid bdd56beb-6847-4e78-96fe-cec4e15ff245 */
   private String image;
   /** @pdOid 61b35051-d0b9-496d-8c74-d6a0fcba8f6c */
   private String address;
   /** @pdOid fb01c256-e0a7-4c85-bc64-9a60e328e544 */
   private double longitude;
   /** @pdOid 78d64a63-5b6c-4c48-9a7d-52f15576b997 */
   private double latitude;
   
   /** @pdRoleInfo migr=no name=Building assc=Association_13 coll=java.util.Collection impl=java.util.HashSet mult=1..* type=Composition */
   public java.util.Collection<Building> building;
   
   
   /** @pdGenerated default getter */
   public java.util.Collection<Building> getBuilding() {
      if (building == null)
         building = new java.util.HashSet<Building>();
      return building;
   }
   
   /** @pdGenerated default iterator getter */
   public java.util.Iterator getIteratorBuilding() {
      if (building == null)
         building = new java.util.HashSet<Building>();
      return building.iterator();
   }
   
   /** @pdGenerated default setter
     * @param newBuilding */
   public void setBuilding(java.util.Collection<Building> newBuilding) {
      removeAllBuilding();
      for (java.util.Iterator iter = newBuilding.iterator(); iter.hasNext();)
         addBuilding((Building)iter.next());
   }
   
   /** @pdGenerated default add
     * @param newBuilding */
   public void addBuilding(Building newBuilding) {
      if (newBuilding == null)
         return;
      if (this.building == null)
         this.building = new java.util.HashSet<Building>();
      if (!this.building.contains(newBuilding))
         this.building.add(newBuilding);
   }
   
   /** @pdGenerated default remove
     * @param oldBuilding */
   public void removeBuilding(Building oldBuilding) {
      if (oldBuilding == null)
         return;
      if (this.building != null)
         if (this.building.contains(oldBuilding))
            this.building.remove(oldBuilding);
   }
   
   /** @pdGenerated default removeAll */
   public void removeAllBuilding() {
      if (building != null)
         building.clear();
   }

}