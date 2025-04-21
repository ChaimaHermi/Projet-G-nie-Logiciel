/***********************************************************************
 * Module:  Cluster.java
 * Author:  ayeta
 * Purpose: Defines the Class Cluster
 ***********************************************************************/

import java.util.*;

/** @pdOid 9bf4fde6-e933-4d3f-82b0-12dd03defbcb */
public class Cluster {
   /** @pdOid 286d2bc8-7632-4a9a-a882-d948c5ae0ef2 */
   private String name;
   /** @pdOid dd80a700-2a72-4b4b-98ca-540675b17c8e */
   private String description;
   /** @pdOid a509d3a7-58a1-4bd6-aa47-fa73bf3b5279 */
   private String reference;
   /** @pdOid a711a9f4-0ac1-4852-a5dc-66c820ec2eb5 */
   private String image;
   /** @pdOid cc3ce724-d87f-41c8-87b2-88ecada46c15 */
   private String address;
   /** @pdOid 4882dd53-a10a-4a62-862c-c661217ab170 */
   private double longitude;
   /** @pdOid 81d774ee-8f0c-4e16-94c9-fa99c46a91fb */
   private double latitude;
   
   /** @pdRoleInfo migr=no name=Facility assc=Association_14 coll=java.util.Collection impl=java.util.HashSet mult=1..* type=Composition */
   public java.util.Collection<Facility> facility;
   
   
   /** @pdGenerated default getter */
   public java.util.Collection<Facility> getFacility() {
      if (facility == null)
         facility = new java.util.HashSet<Facility>();
      return facility;
   }
   
   /** @pdGenerated default iterator getter */
   public java.util.Iterator getIteratorFacility() {
      if (facility == null)
         facility = new java.util.HashSet<Facility>();
      return facility.iterator();
   }
   
   /** @pdGenerated default setter
     * @param newFacility */
   public void setFacility(java.util.Collection<Facility> newFacility) {
      removeAllFacility();
      for (java.util.Iterator iter = newFacility.iterator(); iter.hasNext();)
         addFacility((Facility)iter.next());
   }
   
   /** @pdGenerated default add
     * @param newFacility */
   public void addFacility(Facility newFacility) {
      if (newFacility == null)
         return;
      if (this.facility == null)
         this.facility = new java.util.HashSet<Facility>();
      if (!this.facility.contains(newFacility))
         this.facility.add(newFacility);
   }
   
   /** @pdGenerated default remove
     * @param oldFacility */
   public void removeFacility(Facility oldFacility) {
      if (oldFacility == null)
         return;
      if (this.facility != null)
         if (this.facility.contains(oldFacility))
            this.facility.remove(oldFacility);
   }
   
   /** @pdGenerated default removeAll */
   public void removeAllFacility() {
      if (facility != null)
         facility.clear();
   }

}